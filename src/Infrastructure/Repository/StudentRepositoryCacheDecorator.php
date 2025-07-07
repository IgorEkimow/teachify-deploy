<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;
use App\Infrastructure\Repository\StudentRepository;
use App\Domain\Repository\StudentRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class StudentRepositoryCacheDecorator implements StudentRepositoryInterface
{
    private const CACHE_KEY_ALL_STUDENTS = 'students_all';
    private const CACHE_TTL = 3600;

    public function __construct(
        private readonly StudentRepository $studentRepository,
        private readonly CacheItemPoolInterface $cache
    ) {
    }

    /**
     * @return Student[]
     * @throws InvalidArgumentException
     */
    public function getAllCached(): array
    {
        $cacheItem = $this->cache->getItem(self::CACHE_KEY_ALL_STUDENTS);

        if (!$cacheItem->isHit()) {
            $students = $this->studentRepository->findAll();
            $cacheItem->set(serialize($students))->expiresAfter(self::CACHE_TTL);
            $this->cache->save($cacheItem);

            return $students;
        }

        return unserialize($cacheItem->get());
    }

    public function clearCache(): void
    {
        $this->cache->deleteItem(self::CACHE_KEY_ALL_STUDENTS);
    }
}