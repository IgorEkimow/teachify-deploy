<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Teacher;
use App\Domain\Model\TeacherMatchingCriteria;
use App\Infrastructure\Repository\TeacherRepository;

class TeacherMatcherService
{
    private const MIN_SCORE_THRESHOLD = 0.1;

    public function __construct(
        private readonly TeacherRepository $teacherRepository
    ) {
    }

    public function findBestMatchForGroup(Group $group, TeacherMatchingCriteria $criteria): ?Teacher
    {
        $eligibleTeachers = $this->findEligibleTeachers($group, $criteria);

        if (empty($eligibleTeachers)) {
            return null;
        }

        arsort($eligibleTeachers);

        return $this->teacherRepository->find(key($eligibleTeachers));
    }

    private function findEligibleTeachers(Group $group, TeacherMatchingCriteria $criteria): array
    {
        $groupSkills = $this->getGroupSkillNames($group);
        $eligibleTeachers = [];

        foreach ($this->teacherRepository->findAll() as $teacher) {
            $score = $this->calculateTeacherScore($teacher, $groupSkills, $criteria);

            if ($score >= self::MIN_SCORE_THRESHOLD) {
                $eligibleTeachers[$teacher->getId()] = $score;
            }
        }

        return $eligibleTeachers;
    }

    private function calculateTeacherScore(Teacher $teacher, array $groupSkills, TeacherMatchingCriteria $criteria): float
    {
        if (!$this->isTeacherAvailable($teacher, $criteria)) {
            return 0;
        }

        $teacherSkills = $this->getTeacherSkillNames($teacher);
        $commonSkills = array_intersect($groupSkills, $teacherSkills);

        if (!$this->hasSufficientCommonSkills($commonSkills, $groupSkills, $criteria)) {
            return 0;
        }

        return $this->calculateFinalScore(
            count($commonSkills),
            count($groupSkills),
            $teacher->getGroups()->count(),
            $criteria
        );
    }

    private function isTeacherAvailable(Teacher $teacher, TeacherMatchingCriteria $criteria): bool
    {
        $groupsCount = $teacher->getGroups()->count();
        return $groupsCount < $criteria->maxGroupsPerTeacher;
    }

    private function hasSufficientCommonSkills(
        array $commonSkills,
        array $groupSkills,
        TeacherMatchingCriteria $criteria
    ): bool {
        if (empty($commonSkills)) {
            return false;
        }

        $skillCoverage = count($commonSkills) / max(1, count($groupSkills));
        return $skillCoverage >= $criteria->minSkillCoverage;
    }

    private function calculateFinalScore(
        int $commonSkillsCount,
        int $totalGroupSkills,
        int $currentTeacherGroups,
        TeacherMatchingCriteria $criteria
    ): float {
        $skillScore = ($commonSkillsCount / max(1, $totalGroupSkills)) * 0.6;
        $availabilityScore = (1 - ($currentTeacherGroups / $criteria->maxGroupsPerTeacher)) * 0.3;
        $countScore = min(1, $commonSkillsCount / 5) * 0.1;

        return $skillScore + $availabilityScore + $countScore;
    }

    private function getGroupSkillNames(Group $group): array
    {
        return array_unique($group->getSkills()->map(fn(Skill $skill) => $skill->getName())->toArray());
    }

    private function getTeacherSkillNames(Teacher $teacher): array
    {
        return array_unique($teacher->getSkills()->map(fn($teacherSkill) => $teacherSkill->getSkill()->getName())->toArray());
    }
}