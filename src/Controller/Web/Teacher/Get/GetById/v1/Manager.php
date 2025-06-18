<?php

namespace App\Controller\Web\Teacher\Get\GetById\v1;

use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    public function getTeacherById(int $teacherId): ?Teacher
    {
        return $this->teacherService->findById($teacherId);
    }
}