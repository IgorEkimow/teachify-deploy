<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Model\GetStudentModel;
use App\Domain\Model\UpdateLoginStudentModel;
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

    public function findById(GetStudentModel $getStudentModel): ?Student
    {
        return $this->studentRepository->find($getStudentModel->id);
    }

    public function findByLogin(CreateStudentModel $createStudentModel): ?Student
    {
        $student = $this->studentRepository->findByLogin($createStudentModel->login);
        return $student[0] ?? null;
    }

    public function findAll(): array
    {
        return $this->studentRepository->findAll();
    }

    public function updateLogin(Student $student, UpdateLoginStudentModel $updateLoginStudentModel): void
    {
        $this->studentRepository->updateLogin($student, $updateLoginStudentModel->login);
    }

    public function remove(Student $student): void
    {
        $this->studentRepository->remove($student);
    }
}