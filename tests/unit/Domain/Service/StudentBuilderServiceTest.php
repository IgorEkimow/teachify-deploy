<?php

namespace UnitTests\Tests\Domain\Service;

use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Service\SkillService;
use App\Domain\Service\StudentBuilderService;
use App\Domain\Service\StudentService;
use App\Domain\Service\StudentSkillService;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
class StudentBuilderServiceTest extends TestCase
{
    private StudentBuilderService $service;
    private StudentService $studentServiceMock;
    private SkillService $skillServiceMock;
    private StudentSkillService $studentSkillServiceMock;

    protected function setUp(): void
    {
        $this->studentServiceMock = $this->createMock(StudentService::class);
        $this->skillServiceMock = $this->createMock(SkillService::class);
        $this->studentSkillServiceMock = $this->createMock(StudentSkillService::class);

        $this->service = new StudentBuilderService(
            $this->studentServiceMock,
            $this->skillServiceMock,
            $this->studentSkillServiceMock
        );
    }

    public function testCreateStudentWithNewSkills(): void
    {
        $model = new CreateStudentModel(name: 'Mike', login: 'mike', password: 'password', skills: ['PHP', 'JavaScript'], roles: ['ROLE_STUDENT']);

        $student = new Student();
        $student->setId(1);
        $student->setName($model->name);

        $phpSkill = new Skill();
        $phpSkill->setId(1);
        $phpSkill->setName('PHP');

        $jsSkill = new Skill();
        $jsSkill->setId(2);
        $jsSkill->setName('JavaScript');

        $this->studentServiceMock->method('create')->willReturn($student);
        $this->skillServiceMock->method('findByName')->willReturn(null);
        $this->skillServiceMock->method('create')->willReturnOnConsecutiveCalls($phpSkill, $jsSkill);
        $this->studentSkillServiceMock->expects($this->exactly(2))->method('create');

        $result = $this->service->createStudentWithSkill($model);

        $this->assertSame($student, $result);
        $this->assertEquals('Mike', $result->getName());
    }

    public function testCreateStudentWithExistingSkills(): void
    {
        $model = new CreateStudentModel(name: 'Alex', login: 'alex', password: 'password', skills: ['PHP'], roles: ['ROLE_STUDENT']);

        $student = new Student();
        $student->setId(1);
        $student->setName($model->name);

        $phpSkill = new Skill();
        $phpSkill->setId(1);
        $phpSkill->setName('PHP');

        $this->studentServiceMock->method('create')->willReturn($student);
        $this->skillServiceMock->method('findByName')->with('PHP')->willReturn($phpSkill);
        $this->studentSkillServiceMock->expects($this->once())->method('create');

        $result = $this->service->createStudentWithSkill($model);

        $this->assertSame($student, $result);
    }

    public function testCreateStudentWithEmptySkills(): void
    {
        $model = new CreateStudentModel(name: 'John', login: 'john', password: 'password', skills: [], roles: ['ROLE_STUDENT']);

        $student = new Student();
        $student->setId(1);
        $student->setName($model->name);

        $this->studentServiceMock->method('create')->willReturn($student);
        $this->skillServiceMock->expects($this->never())->method('findByName');
        $this->studentSkillServiceMock->expects($this->never())->method('create');

        $result = $this->service->createStudentWithSkill($model);

        $this->assertSame($student, $result);
    }

    public function testCreateStudentWithDuplicateSkills(): void
    {
        $model = new CreateStudentModel(name: 'Nick', login: 'nick', password: 'password', skills: ['PHP', 'PHP'], roles: ['ROLE_STUDENT']);

        $student = new Student();
        $student->setId(1);
        $student->setName($model->name);

        $phpSkill = new Skill();
        $phpSkill->setId(1);
        $phpSkill->setName('PHP');

        $this->studentServiceMock->method('create')->willReturn($student);
        $this->skillServiceMock->method('findByName')->with('PHP')->willReturn($phpSkill);
        $this->studentSkillServiceMock->expects($this->once())->method('create');

        $result = $this->service->createStudentWithSkill($model);

        $this->assertSame($student, $result);
    }
}