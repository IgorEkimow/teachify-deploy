<?php

namespace App\Domain\Service;

use App\Domain\Entity\Admin;
use App\Domain\Entity\Student;
use App\Domain\Entity\Teacher;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly AdminService $adminService,
        private readonly StudentService $studentService,
        private readonly TeacherService $teacherService
    ) {
    }

    public function findUserByLogin(string $login): Admin|Student|Teacher|null
    {
        return $this->adminService->findUserByLogin($login) ?? $this->studentService->findUserByLogin($login) ?? $this->teacherService->findUserByLogin($login);
    }

    public function findUserByToken(string $token): Admin|Student|Teacher|null
    {
        return $this->adminService->findUserByToken($token) ?? $this->studentService->findUserByToken($token) ?? $this->teacherService->findUserByToken($token);
    }

    public function updateUserToken(string $login): ?string
    {
        $user = $this->findUserByLogin($login);
        if ($user instanceof Admin) {
            return $this->adminService->updateUserToken($login);
        }

        if ($user instanceof Student) {
            return $this->studentService->updateUserToken($login);
        }

        if ($user instanceof Teacher) {
            return $this->teacherService->updateUserToken($login);
        }

        return null;
    }

    public function clearUserToken(string $login): void
    {
        $user = $this->findUserByLogin($login);
        if ($user instanceof Admin) {
            $this->adminService->clearUserToken($login);
        }

        if ($user instanceof Student) {
            $this->studentService->clearUserToken($login);
        }

        if ($user instanceof Teacher) {
            $this->teacherService->clearUserToken($login);
        }
    }
}