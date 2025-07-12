<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Admin;

/**
 * @extends AbstractRepository<Admin>
 */
class AdminRepository extends AbstractRepository
{
    public function create(Admin $admin): int
    {
        return $this->store($admin);
    }

    public function find(int $id): ?Admin
    {
        return $this->entityManager->getRepository(Admin::class)
            ->createQueryBuilder('a')
            ->where('a.id = :id')
            ->andWhere('a.deletedAt IS NULL')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByLogin(string $login): array
    {
        return $this->entityManager->getRepository(Admin::class)
            ->createQueryBuilder('a')
            ->where('a.login = :login')
            ->andWhere('a.deletedAt IS NULL')
            ->setParameter('login', $login)
            ->getQuery()
            ->getResult();
    }

    public function findByToken(string $token): ?Admin
    {
        return $this->entityManager->getRepository(Admin::class)
            ->createQueryBuilder('a')
            ->where('a.token = :token')
            ->andWhere('a.deletedAt IS NULL')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Admin::class)
            ->createQueryBuilder('a')
            ->where('a.deletedAt IS NULL')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function updateToken(Admin $admin): string
    {
        $token = base64_encode(random_bytes(20));
        $admin->setToken($token);
        $this->flush();

        return $token;
    }

    public function clearToken(Admin $admin): void
    {
        $admin->setToken(null);
        $this->flush();
    }

    public function remove(Admin $admin): void
    {
        $admin->setDeletedAt();
        $this->flush();
    }
}