<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;
use App\Infrastructure\Repository\GroupRepository;
use App\Domain\Repository\GroupRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class GroupRepositoryCacheDecorator implements GroupRepositoryInterface
{
    private const CACHE_KEY_ALL_GROUPS = 'groups_all';
    private const CACHE_TTL = 3600;

    public function __construct(
        private readonly GroupRepository $groupRepository,
        private readonly CacheItemPoolInterface $cache
    ) {
    }

    /**
     * @return Group[]
     * @throws InvalidArgumentException
     */
    public function getAllCached(): array
    {
        $cacheItem = $this->cache->getItem(self::CACHE_KEY_ALL_GROUPS);

        if (!$cacheItem->isHit()) {
            $groups = $this->groupRepository->findAll();
            $cacheItem->set(serialize($groups))->expiresAfter(self::CACHE_TTL);
            $this->cache->save($cacheItem);

            return $groups;
        }

        return unserialize($cacheItem->get());
    }

    public function clearCache(): void
    {
        $this->cache->deleteItem(self::CACHE_KEY_ALL_GROUPS);
    }
}