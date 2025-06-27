<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use App\Domain\Entity\Teacher;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly StudentService $studentService,
        private readonly TeacherService $teacherService
    ) {
    }

    public function findUserByLogin(string $login): Student|Teacher|null
    {
        return $this->studentService->findUserByLogin($login) ?? $this->teacherService->findUserByLogin($login);
    }

    public function findUserByToken(string $token): Student|Teacher|null
    {
        return $this->studentService->findUserByToken($token) ?? $this->teacherService->findUserByToken($token);
    }

    public function updateUserToken(string $login): ?string
    {
        $user = $this->findUserByLogin($login);
        if ($user instanceof Student) {
            return $this->studentService->updateUserToken($login);
        }

        if ($user instanceof Teacher) {
            return $this->teacherService->updateUserToken($login);
        }

        return null;
    }
}