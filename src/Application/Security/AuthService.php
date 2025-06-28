<?php

namespace App\Application\Security;

use App\Domain\Service\UserServiceInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly JWTEncoderInterface $jwtEncoder
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

    /**
     * @throws JWTEncodeFailureException
     */
    public function getToken(string $login): string
    {
        $user = $this->userService->findUserByLogin($login);
        $refreshToken = $this->userService->updateUserToken($login);
        $tokenData = [
            'username' => $login,
            'roles' => $user?->getRoles() ?? [],
            'exp' => time() + 600,
            'refresh_token' => $refreshToken,
        ];

        return $this->jwtEncoder->encode($tokenData);
    }
}