<?php

namespace App\Controller\Web\Student\Get\GetAll\v1;

use App\Domain\Service\StudentService;

readonly class Manager
{
    public function __construct(private StudentService $studentService)
    {
    }

    public function getAllStudents(): array
    {
        return $this->studentService->findAll();
    }
}