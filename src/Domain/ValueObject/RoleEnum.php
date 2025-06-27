<?php

namespace App\Domain\ValueObject;

enum RoleEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_STUDENT = 'ROLE_STUDENT';
    case ROLE_TEACHER = 'ROLE_TEACHER';
    case ROLE_USER = 'ROLE_USER';
}