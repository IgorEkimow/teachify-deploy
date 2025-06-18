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

    public function findById(int $id): ?Student
    {
        return $this->studentRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->studentRepository->findAll();
    }

    public function updateLogin(Student $student, string $login): void
    {
        $this->studentRepository->updateLogin($student, $login);
    }

    public function remove(Student $student): void
    {
        $this->studentRepository->remove($student);
    }
}