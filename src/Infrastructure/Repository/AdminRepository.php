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

    public function find(int $adminId): ?Admin
    {
        return $this->entityManager->getRepository(Admin::class)->find($adminId);
    }

    public function findByLogin(string $login): array
    {
        return $this->entityManager->getRepository(Admin::class)->findBy(['login' => $login]);
    }

    public function findByToken(string $token): ?Admin
    {
        return $this->entityManager->getRepository(Admin::class)->findOneBy(['token' => $token]);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Admin::class)->findAll();
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