<?php

namespace App\Controller\Web\Group\Get\GetAll\v1;

use App\Domain\Repository\GroupRepositoryInterface;

readonly class Manager
{
    public function __construct(private GroupRepositoryInterface $groupRepositoryInterface)
    {
    }

    public function getAll(): array
    {
        return $this->groupRepositoryInterface->getAllCached();
    }
}