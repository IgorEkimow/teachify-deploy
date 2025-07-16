<?php

namespace UnitTests\Tests\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Teacher;
use App\Domain\Entity\TeacherSkill;
use App\Domain\Model\TeacherMatchingCriteria;
use App\Domain\Service\TeacherMatcherService;
use App\Infrastructure\Repository\TeacherRepository;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class TeacherMatcherServiceTest extends TestCase
{
    private TeacherMatcherService $matcher;
    private TeacherRepository $teacherRepository;

    protected function setUp(): void
    {
        $this->teacherRepository = $this->createMock(TeacherRepository::class);
        $this->matcher = new TeacherMatcherService($this->teacherRepository);
    }

    public function testNoMatchWhenTeachersAreAtCapacity()
    {
        $group = $this->createGroupWithSkills(['PHP']);
        $teacher = $this->createTeacherWithSkills(1, 'Busy Teacher', ['PHP']);

        for ($i = 0; $i < 5; $i++) {
            $teacher->getGroups()->add(new Group());
        }

        $this->teacherRepository->method('findAll')->willReturn([$teacher]);
        $result = $this->matcher->findBestMatchForGroup($group, new TeacherMatchingCriteria(maxGroupsPerTeacher: 5, minSkillCoverage: 0.5));

        $this->assertNull($result);
    }

    public function testNoMatchWhenInsufficientSkillCoverage()
    {
        $group = $this->createGroupWithSkills(['PHP', 'Symfony', 'Doctrine']);
        $teacher = $this->createTeacherWithSkills(1, 'Partial Match Teacher', ['PHP']);

        $this->teacherRepository->method('findAll')->willReturn([$teacher]);
        $result = $this->matcher->findBestMatchForGroup($group, new TeacherMatchingCriteria(maxGroupsPerTeacher: 5, minSkillCoverage: 0.66));

        $this->assertNull($result);
    }

    public function testScoreCalculationComponents()
    {
        $group = $this->createGroupWithSkills(['PHP', 'Symfony', 'JavaScript']);
        $teacher = $this->createTeacherWithSkills(1, 'Test Teacher', ['PHP', 'Symfony']);
        $teacher->getGroups()->add(new Group());
        $teacher->getGroups()->add(new Group());

        $this->teacherRepository->method('findAll')->willReturn([$teacher]);
        $eligibleTeachers = $this->matcher->findEligibleTeachers($group, new TeacherMatchingCriteria(maxGroupsPerTeacher: 5, minSkillCoverage: 0.5));

        $this->assertCount(1, $eligibleTeachers);
        $this->assertEqualsWithDelta(0.62, reset($eligibleTeachers), 0.01);
    }

    private function createGroupWithSkills(array $skillNames): Group
    {
        $group = new Group();
        $group->setName('Test Group');

        foreach ($skillNames as $name) {
            $skill = new Skill();
            $skill->setName($name);
            $group->addSkill($skill);
        }

        return $group;
    }

    private function createTeacherWithSkills(int $id, string $name, array $skillNames): Teacher
    {
        $teacher = new Teacher();
        $teacher->setId($id);
        $teacher->setName($name);

        foreach ($skillNames as $name) {
            $skill = new Skill();
            $skill->setName($name);

            $teacherSkill = new TeacherSkill();
            $teacherSkill->setSkill($skill);
            $teacher->addSkill($teacherSkill);
        }

        return $teacher;
    }
}