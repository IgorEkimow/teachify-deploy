<?php

namespace App\Controller\Web\Student\Delete\v1;

use App\Domain\Entity\Student;
use App\Domain\Service\StudentService;

readonly class Manager
{
    public function __construct(private StudentService $studentService)
    {
    }

    public function deleteStudent(Student $student): void
    {
        $this->studentService->remove($student);
    }
}