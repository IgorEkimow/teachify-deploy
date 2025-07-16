<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Model\GroupMatchingCriteria;
use App\Infrastructure\Repository\GroupRepository;

class GroupMatcherService
{
    private const MIN_SCORE_THRESHOLD = 0.1;

    public function __construct(
        private readonly GroupRepository $groupRepository
    ) {
    }

    public function findBestMatchForStudent(Student $student, GroupMatchingCriteria $criteria): ?Group
    {
        $eligibleGroups = $this->findEligibleGroups($student, $criteria);

        if (empty($eligibleGroups)) {
            return null;
        }

        arsort($eligibleGroups);

        return $this->groupRepository->find(key($eligibleGroups));
    }

    public function findEligibleGroups(Student $student, GroupMatchingCriteria $criteria): array
    {
        $studentSkills = $this->getStudentSkillNames($student);
        $eligibleGroups = [];

        foreach ($this->groupRepository->findAll() as $group) {
            $score = $this->calculateGroupScore($group, $studentSkills, $criteria);

            if ($score >= self::MIN_SCORE_THRESHOLD) {
                $eligibleGroups[$group->getId()] = $score;
            }
        }

        return $eligibleGroups;
    }

    private function calculateGroupScore(Group $group, array $studentSkills, GroupMatchingCriteria $criteria): float
    {
        if (!$this->isGroupSizeValid($group, $criteria)) {
            return 0;
        }

        $groupSkills = $this->getGroupSkillNames($group);
        $commonSkills = array_intersect($studentSkills, $groupSkills);

        if (!$this->hasSufficientCommonSkills($commonSkills, $groupSkills, $criteria)) {
            return 0;
        }

        return $this->calculateFinalScore(
            count($commonSkills),
            count($groupSkills),
            $group->getStudents()->count(),
            $criteria
        );
    }

    private function isGroupSizeValid(Group $group, GroupMatchingCriteria $criteria): bool
    {
        $studentsCount = $group->getStudents()->count();
        return $studentsCount < $criteria->maxGroupSize;
    }

    private function hasSufficientCommonSkills(
        array $commonSkills,
        array $groupSkills,
        GroupMatchingCriteria $criteria
    ): bool {
        if (empty($commonSkills)) {
            return false;
        }

        $unwantedSkillsRatio = (count($groupSkills) - count($commonSkills)) / max(1, count($groupSkills));
        return $unwantedSkillsRatio <= $criteria->maxUnwantedSkillsRatio;
    }

    private function calculateFinalScore(
        int $commonSkillsCount,
        int $totalGroupSkills,
        int $currentGroupSize,
        GroupMatchingCriteria $criteria
    ): float {
        $skillScore = ($commonSkillsCount / max(1, $totalGroupSkills)) * 0.6;
        $sizeScore = (1 - ($currentGroupSize / $criteria->maxGroupSize)) * 0.3;
        $countScore = min(1, $commonSkillsCount / 5) * 0.1;

        return $skillScore + $sizeScore + $countScore;
    }

    private function getStudentSkillNames(Student $student): array
    {
        return array_unique($student->getSkills()->map(fn($studentSkill) => $studentSkill->getSkill()->getName())->toArray());
    }

    private function getGroupSkillNames(Group $group): array
    {
        return array_unique($group->getSkills()->map(fn(Skill $skill) => $skill->getName())->toArray());
    }
}