<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Admin;
use App\Domain\Repository\AdminRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class AdminRepositoryCacheDecorator implements AdminRepositoryInterface
{
    private const CACHE_KEY_ALL_ADMINS = 'admin_all';
    private const CACHE_TTL = 3600;

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly CacheItemPoolInterface $cache
    ) {
    }

    /**
     * @return Admin[]
     * @throws InvalidArgumentException
     */
    public function getAllCached(): array
    {
        $cacheItem = $this->cache->getItem(self::CACHE_KEY_ALL_ADMINS);

        if (!$cacheItem->isHit()) {
            $admins = $this->adminRepository->findAll();
            $cacheItem->set(serialize($admins))->expiresAfter(self::CACHE_TTL);
            $this->cache->save($cacheItem);

            return $admins;
        }

        return unserialize($cacheItem->get());
    }

    public function clearCache(): void
    {
        $this->cache->deleteItem(self::CACHE_KEY_ALL_ADMINS);
    }
}