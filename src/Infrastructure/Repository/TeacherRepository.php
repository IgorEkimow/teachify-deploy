<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Teacher;

/**
 * @extends AbstractRepository<Teacher>
 */
class TeacherRepository extends AbstractRepository
{
    public function create(Teacher $teacher): int
    {
        return $this->store($teacher);
    }

    public function find(int $teacherId): ?Teacher
    {
        return $this->entityManager->getRepository(Teacher::class)->find($teacherId);
    }

    public function findByLogin(string $login): array
    {
        return $this->entityManager->getRepository(Teacher::class)->findBy(['login' => $login]);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Teacher::class)->findAll();
    }

    public function updateLogin(Teacher $teacher, string $login): void
    {
        $teacher->setLogin($login);
        $this->flush();
    }

    public function remove(Teacher $teacher): void
    {
        $teacher->setDeletedAt();
        $this->flush();
    }
}