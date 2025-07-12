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

    public function find(int $id): ?Group
    {
        return $this->entityManager->getRepository(Group::class)
            ->createQueryBuilder('g')
            ->where('g.id = :id')
            ->andWhere('g.deletedAt IS NULL')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByName(string $name): array
    {
        return $this->entityManager->getRepository(Group::class)
            ->createQueryBuilder('g')
            ->where('g.name = :name')
            ->andWhere('g.deletedAt IS NULL')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Group::class)
            ->createQueryBuilder('g')
            ->where('g.deletedAt IS NULL')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function update(Group $group, bool $flush = true): void
    {
        $this->entityManager->persist($group);

        if ($flush) {
            $this->flush();
        }
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