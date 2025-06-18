<?php

namespace App\Controller\Web\Student\Delete\v1;

use App\Domain\Entity\Student;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    public function deleteStudent(Student $student): void
    {
        $this->studentService->remove($student);
    }
}