<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Skill;

/**
 * @extends AbstractRepository<Skill>
 */
class SkillRepository extends AbstractRepository
{
    public function create(Skill $skill): int
    {
        return $this->store($skill);
    }

    public function findByName(string $name): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('s')
            ->from(Skill::class, 's')
            ->where('s.name = :name')
            ->orderBy('s.id', 'ASC')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
}