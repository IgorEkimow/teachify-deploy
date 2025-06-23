<?php

namespace App\Controller\Web\Group\Update\UpdateName\v1;

use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;

class Manager
{
    public function __construct(private readonly GroupService $groupService)
    {
    }

    public function updateName(Group $group, string $name): void
    {
        $this->groupService->updateName($group, $name);
    }
}