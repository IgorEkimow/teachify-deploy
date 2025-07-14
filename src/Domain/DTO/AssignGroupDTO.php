<?php

namespace App\Domain\DTO;

class AssignGroupDTO
{
    public function __construct(
        public readonly int $id,
        public readonly array $skills
    ) {
    }
}