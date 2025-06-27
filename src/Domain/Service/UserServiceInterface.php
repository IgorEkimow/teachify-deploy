<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use App\Domain\Entity\Teacher;

interface UserServiceInterface
{
    public function findUserByLogin(string $login): Student|Teacher|null;
    public function findUserByToken(string $token): Student|Teacher|null;
    public function updateUserToken(string $login): ?string;
}