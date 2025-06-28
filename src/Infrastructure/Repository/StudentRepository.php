<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;

/**
 * @extends AbstractRepository<Student>
 */
class StudentRepository extends AbstractRepository
{
    public function create(Student $student): int
    {
        return $this->store($student);
    }

    public function find(int $studentId): ?Student
    {
        return $this->entityManager->getRepository(Student::class)->find($studentId);
    }

    public function findByLogin(string $login): array
    {
        return $this->entityManager->getRepository(Student::class)->findBy(['login' => $login]);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Student::class)->findAll();
    }

    public function updateLogin(Student $student, string $login): void
    {
        $student->setLogin($login);
        $this->flush();
    }

    public function remove(Student $student): void
    {
        $student->setDeletedAt();
        $this->flush();
    }
}