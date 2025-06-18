<?php

namespace App\Controller\Web\Student\Create\v1;

use App\Domain\Entity\Student;
use App\Domain\Service\StudentService;
use App\Domain\Service\StudentBuilderService;

class Manager
{
    public function __construct(private readonly StudentService $studentService, private readonly StudentBuilderService $studentBuilderService)
    {
    }

    public function createStudent(string $name, string $login): ?Student
    {
        return $this->studentService->create($name, $login);
    }

    public function createStudentWithSkill(string $name, string $login, array $skills): ?Student
    {
        return $this->studentBuilderService->createStudentWithSkill($name, $login, $skills);
    }
}