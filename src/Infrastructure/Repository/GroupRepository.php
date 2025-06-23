<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;

/**
 * @extends AbstractRepository<Group>
 */
class GroupRepository extends AbstractRepository
{
    public function create(Group $group): int
    {
        return $this->store($group);
    }

    public function update(Group $group, bool $flush = true): void
    {
        $this->entityManager->persist($group);

        if ($flush) {
            $this->flush();
        }
    }

    public function findGroupByName(string $name): array
    {
        return $this->entityManager->getRepository(Group::class)->findBy(['name' => $name]);
    }

    public function find(int $groupId): ?Group
    {
        return $this->entityManager->getRepository(Group::class)->find($groupId);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Group::class)->findAll();
    }

    public function updateName(Group $group, string $name): void
    {
        $group->setName($name);
        $this->flush();
    }

    public function remove(Group $group): void
    {
        $group->setDeletedAt();
        $this->flush();
    }
}