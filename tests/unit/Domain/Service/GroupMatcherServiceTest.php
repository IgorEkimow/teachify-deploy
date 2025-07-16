<?php

namespace UnitTests\Tests\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Entity\StudentSkill;
use App\Domain\Model\GroupMatchingCriteria;
use App\Domain\Service\GroupMatcherService;
use App\Infrastructure\Repository\GroupRepository;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class GroupMatcherServiceTest extends TestCase
{
    private GroupMatcherService $matcher;
    private GroupRepository $groupRepository;

    protected function setUp(): void
    {
        $this->groupRepository = $this->createMock(GroupRepository::class);
        $this->matcher = new GroupMatcherService($this->groupRepository);
    }

    public function testNoMatchWhenNoGroupsAvailable()
    {
        $student = $this->createStudentWithSkills(['PHP']);
        $this->groupRepository->method('findAll')->willReturn([]);
        $result = $this->matcher->findBestMatchForStudent($student, new GroupMatchingCriteria(requiredSkills: ['PHP'], maxGroupSize: 20, maxUnwantedSkillsRatio: 0.3));

        $this->assertNull($result);
    }

    public function testNoMatchWhenGroupsAreFull()
    {
        $student = $this->createStudentWithSkills(['PHP']);
        $group = $this->createGroupWithSkills(['PHP'], 20);

        $this->groupRepository->method('findAll')->willReturn([$group]);
        $result = $this->matcher->findBestMatchForStudent($student, new GroupMatchingCriteria(requiredSkills: ['PHP'], maxGroupSize: 20, maxUnwantedSkillsRatio: 0.3));

        $this->assertNull($result);
    }

    public function testNoMatchWhenNoCommonSkills()
    {
        $student = $this->createStudentWithSkills(['PHP']);
        $group = $this->createGroupWithSkills(['JavaScript'], 0);

        $this->groupRepository->method('findAll')->willReturn([$group]);
        $result = $this->matcher->findBestMatchForStudent($student, new GroupMatchingCriteria(requiredSkills: ['JavaScript'], maxGroupSize: 20, maxUnwantedSkillsRatio: 0.3));

        $this->assertNull($result);
    }

    public function testStudentWithNoSkillsGetsNoMatches()
    {
        $student = new Student();
        $group = $this->createGroupWithSkills(['PHP'], 0);

        $this->groupRepository->method('findAll')->willReturn([$group]);
        $result = $this->matcher->findBestMatchForStudent($student, new GroupMatchingCriteria(requiredSkills: ['PHP'], maxGroupSize: 20, maxUnwantedSkillsRatio: 0.3));

        $this->assertNull($result);
    }

    public function testInvalidCriteriaMaxGroupSizeHandledGracefully()
    {
        $student = $this->createStudentWithSkills(['PHP']);
        $group = $this->createGroupWithSkills(['PHP'], 0);

        $this->groupRepository->method('findAll')->willReturn([$group]);
        $result = $this->matcher->findBestMatchForStudent($student, new GroupMatchingCriteria(requiredSkills: ['PHP'], maxGroupSize: 0, maxUnwantedSkillsRatio: 0.3));

        $this->assertNull($result);
    }

    private function createStudentWithSkills(array $skillNames): Student
    {
        $student = new Student();
        $student->setName('Test Student');

        foreach ($skillNames as $name) {
            $skill = new Skill();
            $skill->setName($name);

            $studentSkill = $this->createMock(StudentSkill::class);
            $studentSkill->method('getSkill')->willReturn($skill);
            $student->addSkill($studentSkill);
        }

        return $student;
    }

    private function createGroupWithSkills(array $skillNames, int $studentCount): Group
    {
        $group = new Group();
        $group->setName('Test Group');

        foreach ($skillNames as $name) {
            $skill = new Skill();
            $skill->setName($name);
            $group->addSkill($skill);
        }

        for ($i = 0; $i < $studentCount; $i++) {
            $group->addStudent(new Student());
        }

        return $group;
    }
}