<?php

namespace App\Controller\Web\Teacher\Get\GetAll\v1;

use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    public function getAllTeachers(): array
    {
        return $this->teacherService->findAll();
    }
}