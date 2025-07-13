<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Domain\Model\GetAllGroupModel;
use App\Domain\Repository\GroupRepositoryInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class GroupRepositoryCacheDecorator implements GroupRepositoryInterface
{
    private const CACHE_KEY_ALL_GROUPS = 'groups_all';
    private const CACHE_TAG_GROUPS = 'groups';
    private const CACHE_TTL = 3600;

    public function __construct(
        private readonly GroupRepository $groupRepository,
        private readonly TagAwareCacheInterface $cache
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getAllCached(): array
    {
        $cacheItem = $this->cache->getItem(self::CACHE_KEY_ALL_GROUPS);

        if (!$cacheItem->isHit()) {
            $groups = $this->groupRepository->findAll();
            $groupDto = array_map(function(Group $group) {
                return new GetAllGroupModel(
                    $group->getId(),
                    $group->getName(),
                    $group->getCreatedAt()->format('Y-m-d H:i:s'),
                    $group->getUpdatedAt()->format('Y-m-d H:i:s'),
                    $group->getSkills()->map(fn($skill) => $skill->getName())->toArray(),
                    $group->getStudents()->map(fn($student) => $student->getName())->toArray(),
                    $group->getTeacher() ? $group->getTeacher()->getName() : ''
                );
            }, $groups);

            $cacheItem->set(serialize($groupDto))->expiresAfter(self::CACHE_TTL)->tag([self::CACHE_TAG_GROUPS]);

            $this->cache->save($cacheItem);

            return $groupDto;
        }

        return unserialize($cacheItem->get());
    }

    public function clearCache(): void
    {
        $this->cache->deleteItem(self::CACHE_KEY_ALL_GROUPS);
    }
}