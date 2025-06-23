<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Infrastructure\Repository\GroupRepository;

class GroupService
{
    public function __construct(private readonly GroupRepository $groupRepository)
    {
    }

    public function create(string $name): Group
    {
        $group = new Group();
        $group->setName($name);
        $group->setCreatedAt();
        $group->setUpdatedAt();
        $this->groupRepository->create($group);

        return $group;
    }

    public function findByName(string $name): ?Group
    {
        $group = $this->groupRepository->findGroupByName($name);
        return $group[0] ?? null;
    }

    public function findById(int $id): ?Group
    {
        return $this->groupRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->groupRepository->findAll();
    }

    public function remove(Group $group): void
    {
        $this->groupRepository->remove($group);
    }

    public function updateName(Group $group, string $name): void
    {
        $this->groupRepository->updateName($group, $name);
    }
}