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

    public function findByToken(string $token): ?Student
    {
        return $this->entityManager->getRepository(Student::class)->findOneBy(['token' => $token]);
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

    public function updateToken(Student $student): string
    {
        $token = base64_encode(random_bytes(20));
        $student->setToken($token);
        $this->flush();

        return $token;
    }

    public function clearToken(Student $student): void
    {
        $student->setToken(null);
        $this->flush();
    }

    public function remove(Student $student): void
    {
        $student->setDeletedAt();
        $this->flush();
    }
}