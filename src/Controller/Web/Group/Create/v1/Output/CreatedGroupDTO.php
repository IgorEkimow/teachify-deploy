<?php

namespace App\Controller\Web\Group\Create\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class CreatedGroupDTO implements OutputDTOInterface
{
    public function __construct(
        public int $id,
        public string $name,
        public string $createdAt,
        public string $updatedAt
    ) {
    }
}