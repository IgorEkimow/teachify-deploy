<?php

namespace App\Domain\DTO;

class AssignTeacherDTO
{
    public function __construct(
        public readonly int $id
    ) {
    }
}