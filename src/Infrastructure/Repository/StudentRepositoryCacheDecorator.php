<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;
use App\Domain\Model\GetAllStudentModel;
use App\Domain\Repository\StudentRepositoryInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class StudentRepositoryCacheDecorator implements StudentRepositoryInterface
{
    private const CACHE_KEY_ALL_STUDENTS = 'students_all';
    private const CACHE_TAG_STUDENTS = 'students';
    private const CACHE_TTL = 3600;

    public function __construct(
        private readonly StudentRepository $studentRepository,
        private readonly TagAwareCacheInterface $cache
    ) {
    }

    /**
    * @throws InvalidArgumentException
    */
    public function getAllCached(): array
    {
        $cacheItem = $this->cache->getItem(self::CACHE_KEY_ALL_STUDENTS);

        if (!$cacheItem->isHit()) {
            $students = $this->studentRepository->findAll();
            $studentDto = array_map(function(Student $student) {
                return new GetAllStudentModel(
                    $student->getId(),
                    $student->getName(),
                    $student->getLogin(),
                    $student->getCreatedAt()->format('Y-m-d H:i:s'),
                    $student->getUpdatedAt()->format('Y-m-d H:i:s'),
                    $student->getSkills()->map(fn($skill) => $skill->getSkill()->getName())->toArray(),
                    $student->getRoles()
                );
            }, $students);

            $cacheItem->set(serialize($studentDto))->expiresAfter(self::CACHE_TTL)->tag([self::CACHE_TAG_STUDENTS]);

            $this->cache->save($cacheItem);

            return $studentDto;
        }

        return unserialize($cacheItem->get());
    }

    public function clearCache(): void
    {
        $this->cache->deleteItem(self::CACHE_KEY_ALL_STUDENTS);
    }
}