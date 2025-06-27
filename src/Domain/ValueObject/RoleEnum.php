<?php

namespace App\Domain\ValueObject;

enum RoleEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_USER = 'ROLE_USER';
}