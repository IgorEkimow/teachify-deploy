<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use App\Domain\Model\CreateStudentModel;

class StudentBuilderService
{
    public function __construct(
        private readonly StudentService $studentService,
        private readonly SkillService $skillService,
        private readonly StudentSkillService $studentSkillService
    ) {
    }

    /**
     * @param string[] $skills
     */
    public function createStudentWithSkill(CreateStudentModel $createStudentModel): Student
    {
        $student = $this->studentService->create($createStudentModel);

        foreach ($createStudentModel->skills as $skillName) {
            $skill = $this->skillService->findByName($skillName) ?? $this->skillService->create($skillName);
            $studentSkill = $this->studentSkillService->create($student, $skill);
            $student->addSkill($studentSkill);
        }

        return $student;
    }
}