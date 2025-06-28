<?php

namespace App\Controller\Web\Teacher\Delete\v1;

use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherService;

readonly class Manager
{
    public function __construct(private TeacherService $teacherService)
    {
    }

    public function deleteTeacher(Teacher $teacher): void
    {
        $this->teacherService->remove($teacher);
    }
}