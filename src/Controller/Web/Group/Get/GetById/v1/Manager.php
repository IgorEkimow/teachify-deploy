<?php

namespace App\Controller\Web\Group\Get\GetById\v1;

use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;

class Manager
{
    public function __construct(private readonly GroupService $groupService)
    {
    }

    public function getGroupById(int $groupId): ?Group
    {
        return $this->groupService->findById($groupId);
    }
}