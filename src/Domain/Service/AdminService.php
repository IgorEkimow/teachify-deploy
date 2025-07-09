<?php

namespace App\Domain\Service;

use App\Domain\Entity\Admin;
use App\Domain\Model\CreateAdminModel;
use App\Infrastructure\Repository\AdminRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminService implements UserServiceInterface
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function create(CreateAdminModel $createAdminModel): Admin
    {
        $admin = new Admin();
        $admin->setName($createAdminModel->name);
        $admin->setLogin($createAdminModel->login);
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, $createAdminModel->password));
        $admin->setCreatedAt();
        $admin->setUpdatedAt();
        $admin->setRoles($createAdminModel->roles);
        $this->adminRepository->create($admin);

        return $admin;
    }

    public function findByLogin(CreateAdminModel $createAdminModel): ?Admin
    {
        $admin = $this->adminRepository->findByLogin($createAdminModel->login);
        return $admin[0] ?? null;
    }

    public function findUserByLogin(string $login): ?Admin
    {
        $users = $this->adminRepository->findByLogin($login);

        return $users[0] ?? null;
    }

    public function findUserByToken(string $token): ?Admin
    {
        return $this->adminRepository->findByToken($token);
    }

    public function findAll(): array
    {
        return $this->adminRepository->findAll();
    }

    public function updateUserToken(string $login): ?string
    {
        $user = $this->findUserByLogin($login);
        if ($user === null) {
            return null;
        }

        return $this->adminRepository->updateToken($user);
    }

    public function clearUserToken(string $login): void
    {
        $user = $this->findUserByLogin($login);
        if ($user !== null) {
            $this->adminRepository->clearToken($user);
        }
    }

    public function remove(Admin $admin): void
    {
        $this->adminRepository->remove($admin);
    }
}