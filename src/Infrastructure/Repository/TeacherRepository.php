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

    public function find(int $id): ?Teacher
    {
        return $this->entityManager->getRepository(Teacher::class)
            ->createQueryBuilder('t')
            ->where('t.id = :id')
            ->andWhere('t.deletedAt IS NULL')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByLogin(string $login): array
    {
        return $this->entityManager->getRepository(Teacher::class)
            ->createQueryBuilder('t')
            ->where('t.login = :login')
            ->andWhere('t.deletedAt IS NULL')
            ->setParameter('login', $login)
            ->getQuery()
            ->getResult();
    }

    public function findByToken(string $token): ?Teacher
    {
        return $this->entityManager->getRepository(Teacher::class)
            ->createQueryBuilder('t')
            ->where('t.token = :token')
            ->andWhere('t.deletedAt IS NULL')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Teacher::class)
            ->createQueryBuilder('t')
            ->where('t.deletedAt IS NULL')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function updateLogin(Teacher $teacher, string $login): void
    {
        $teacher->setLogin($login);
        $this->flush();
    }

    public function updateToken(Teacher $teacher): string
    {
        $token = base64_encode(random_bytes(20));
        $teacher->setToken($token);
        $this->flush();

        return $token;
    }

    public function clearToken(Teacher $teacher): void
    {
        $teacher->setToken(null);
        $this->flush();
    }

    public function remove(Teacher $teacher): void
    {
        $teacher->setDeletedAt();
        $this->flush();
    }
}