<?php

namespace App\Controller\Web\Teacher\Update\UpdateLogin\v1;

use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    public function updateLogin(Teacher $teacher, string $login): void
    {
        $this->teacherService->updateLogin($teacher, $login);
    }
}