<?php

namespace App\Domain\Service;

use App\Domain\Entity\Admin;
use App\Domain\Entity\Student;
use App\Domain\Entity\Teacher;

interface UserServiceInterface
{
    public function findUserByLogin(string $login): Admin|Student|Teacher|null;
    public function findUserByToken(string $token): Admin|Student|Teacher|null;
    public function updateUserToken(string $login): ?string;
    public function clearUserToken(string $login): void;
}