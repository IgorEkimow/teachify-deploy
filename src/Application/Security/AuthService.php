<?php

namespace App\Application\Security;

use App\Domain\Service\UserServiceInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function isCredentialsValid(string $login, string $password): bool
    {
        $user = $this->userService->findUserByLogin($login);
        if ($user === null) {
            return false;
        }

        return $this->passwordHasher->isPasswordValid($user, $password);
    }

    public function getToken(string $login): ?string
    {
        return $this->userService->updateUserToken($login);
    }
}