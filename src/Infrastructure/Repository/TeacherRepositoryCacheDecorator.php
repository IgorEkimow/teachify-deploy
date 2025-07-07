<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Teacher;
use App\Infrastructure\Repository\TeacherRepository;
use App\Domain\Repository\TeacherRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class TeacherRepositoryCacheDecorator implements TeacherRepositoryInterface
{
    private const CACHE_KEY_ALL_TEACHERS = 'teachers_all';
    private const CACHE_TTL = 3600;

    public function __construct(
        private readonly TeacherRepository $teacherRepository,
        private readonly CacheItemPoolInterface $cache
    ) {
    }

    /**
     * @return Teacher[]
     * @throws InvalidArgumentException
     */
    public function getAllCached(): array
    {
        $cacheItem = $this->cache->getItem(self::CACHE_KEY_ALL_TEACHERS);

        if (!$cacheItem->isHit()) {
            $teachers = $this->teacherRepository->findAll();
            $cacheItem->set(serialize($teachers))->expiresAfter(self::CACHE_TTL);
            $this->cache->save($cacheItem);

            return $teachers;
        }

        return unserialize($cacheItem->get());
    }

    public function clearCache(): void
    {
        $this->cache->deleteItem(self::CACHE_KEY_ALL_TEACHERS);
    }
}