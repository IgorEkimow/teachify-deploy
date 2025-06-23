<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;

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
    public function createStudentWithSkill(string $name, string $login, array $skills): Student
    {
        $student = $this->studentService->create($name, $login);

        foreach ($skills as $skillName) {
            $skill = $this->skillService->findByName($skillName) ?? $this->skillService->create($skillName);
            $studentSkill = $this->studentSkillService->create($student, $skill);
            $student->addSkill($studentSkill);
        }

        return $student;
    }
}