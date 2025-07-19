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

    public function testSuccessfulMatchWhenGroupHasCommonSkillsAndSpaceAvailable()
    {
        $student = $this->createStudentWithSkills(['PHP', 'JavaScript']);
        $group = $this->createGroupWithSkills(['PHP', 'TypeScript'], 5);
        $group->setId(1);

        $this->groupRepository->method('findAll')->willReturn([$group]);
        $this->groupRepository->method('find')->willReturn($group);

        $criteria = new GroupMatchingCriteria(requiredSkills: ['PHP'], maxGroupSize: 20, maxUnwantedSkillsRatio: 0.5);
        $result = $this->matcher->findBestMatchForStudent($student, $criteria);

        $this->assertNotNull($result);
        $this->assertSame(1, $result->getId());
    }

    public function testSelectsBestMatchingGroupFromMultipleOptions()
    {
        $student = $this->createStudentWithSkills(['PHP', 'JavaScript', 'MySQL']);
        $bestGroup = $this->createGroupWithSkills(['PHP', 'JavaScript', 'MySQL'], 2);
        $bestGroup->setId(1);

        $goodGroup = $this->createGroupWithSkills(['PHP', 'JavaScript', 'TypeScript'], 5);
        $goodGroup->setId(2);

        $minGroup = $this->createGroupWithSkills(['PHP', 'C#', 'Java'], 10);
        $minGroup->setId(3);

        $this->groupRepository->method('findAll')->willReturn([$minGroup, $goodGroup, $bestGroup]);
        $this->groupRepository->method('find')->willReturnCallback(fn($id) => match($id) {1 => $bestGroup,2 => $goodGroup,3 => $minGroup});

        $criteria = new GroupMatchingCriteria(requiredSkills: ['PHP'], maxGroupSize: 20, maxUnwantedSkillsRatio: 0.5);
        $result = $this->matcher->findBestMatchForStudent($student, $criteria);

        $this->assertNotNull($result);
        $this->assertSame(1, $result->getId());
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