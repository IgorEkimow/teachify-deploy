<?php

namespace App\Controller\Web\Teacher\Delete\v1;

use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    public function deleteTeacher(Teacher $student): void
    {
        $this->teacherService->remove($student);
    }
}