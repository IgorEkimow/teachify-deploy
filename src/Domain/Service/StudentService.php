<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use App\Infrastructure\Repository\StudentRepository;

class StudentService
{
    public function __construct(private readonly StudentRepository $studentRepository)
    {
    }

    public function create(string $name, string $login): Student
    {
        $student = new Student();
        $student->setName($name);
        $student->setLogin($login);
        $student->setCreatedAt();
        $student->setUpdatedAt();
        $this->studentRepository->create($student);

        return $student;
    }
}