<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Teacher;
use App\Domain\Model\GetAllTeacherModel;
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
    * @throws InvalidArgumentException
    */
    public function getAllCached(): array
    {
        $cacheItem = $this->cache->getItem(self::CACHE_KEY_ALL_TEACHERS);

        if (!$cacheItem->isHit()) {
            $teachers = $this->teacherRepository->findAll();
            $teacherDto = array_map(function(Teacher $teacher) {
                return new GetAllTeacherModel(
                    $teacher->getId(),
                    $teacher->getName(),
                    $teacher->getLogin(),
                    $teacher->getCreatedAt()->format('Y-m-d H:i:s'),
                    $teacher->getUpdatedAt()->format('Y-m-d H:i:s'),
                    $teacher->getSkills()->map(fn($skill) => $skill->getSkill()->getName())->toArray(),
                    $teacher->getRoles()
                );
            }, $teachers);

            $cacheItem->set(serialize($teacherDto))->expiresAfter(self::CACHE_TTL);
            $this->cache->save($cacheItem);

            return $teacherDto;
        }

        return unserialize($cacheItem->get());
    }

    public function clearCache(): void
    {
        $this->cache->deleteItem(self::CACHE_KEY_ALL_TEACHERS);
    }
}