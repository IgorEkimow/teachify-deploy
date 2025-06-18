<?php

namespace App\Controller\Web\Student\Get\GetById\v1;

use App\Domain\Entity\Student;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    public function getStudentById(int $studentId): ?Student
    {
        return $this->studentService->findById($studentId);
    }
}