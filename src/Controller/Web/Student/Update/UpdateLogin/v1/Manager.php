<?php

namespace App\Controller\Web\Student\Update\UpdateLogin\v1;

use App\Domain\Entity\Student;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    public function updateLogin(Student $student, string $login): void
    {
        $this->studentService->updateLogin($student, $login);
    }
}