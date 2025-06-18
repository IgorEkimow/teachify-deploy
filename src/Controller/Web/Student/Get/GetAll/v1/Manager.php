<?php

namespace App\Controller\Web\Student\Get\GetAll\v1;

use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    public function getAllStudents(): array
    {
        return $this->studentService->findAll();
    }
}