<?php

namespace App\Domain\Service;

use App\Domain\Entity\Teacher;
use App\Domain\Model\CreateTeacherModel;
use App\Domain\Model\GetTeacherModel;
use App\Domain\Model\UpdateLoginTeacherModel;
use App\Infrastructure\Repository\TeacherRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Infrastructure\Repository\TeacherRepositoryCacheDecorator;

class TeacherService implements UserServiceInterface
{
    public function __construct(
        private readonly TeacherRepository $teacherRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly TeacherRepositoryCacheDecorator $cacheDecorator
    ) {
    }

    public function create(CreateTeacherModel $createTeacherModel): Teacher
    {
        $teacher = new Teacher();
        $teacher->setName($createTeacherModel->name);
        $teacher->setLogin($createTeacherModel->login);
        $teacher->setPassword($this->userPasswordHasher->hashPassword($teacher, $createTeacherModel->password));
        $teacher->setRoles($createTeacherModel->roles);
        $teacher->setCreatedAt();
        $teacher->setUpdatedAt();

        $this->teacherRepository->create($teacher);
        $this->cacheDecorator->clearCache();

        return $teacher;
    }

    public function findById(GetTeacherModel $getTeacherModel): ?Teacher
    {
        return $this->teacherRepository->find($getTeacherModel->id);
    }

    public function findByLogin(CreateTeacherModel $createTeacherModel): ?Teacher
    {
        $teacher = $this->teacherRepository->findByLogin($createTeacherModel->login);
        return $teacher[0] ?? null;
    }

    public function findUserByLogin(string $login): ?Teacher
    {
        $users = $this->teacherRepository->findByLogin($login);

        return $users[0] ?? null;
    }

    public function findUserByToken(string $token): ?Teacher
    {
        return $this->teacherRepository->findByToken($token);
    }

    public function findAll(): array
    {
        return $this->teacherRepository->findAll();
    }

    public function updateLogin(Teacher $teacher, UpdateLoginTeacherModel $updateLoginTeacherModel): void
    {
        $this->teacherRepository->updateLogin($teacher, $updateLoginTeacherModel->login);
        $this->cacheDecorator->clearCache();
    }

    public function updateUserToken(string $login): ?string
    {
        $user = $this->findUserByLogin($login);
        if ($user === null) {
            return null;
        }

        return $this->teacherRepository->updateToken($user);
    }

    public function clearUserToken(string $login): void
    {
        $user = $this->findUserByLogin($login);
        if ($user !== null) {
            $this->teacherRepository->clearToken($user);
        }
    }

    public function remove(Teacher $teacher): void
    {
        $this->teacherRepository->remove($teacher);
        $this->cacheDecorator->clearCache();
    }
}