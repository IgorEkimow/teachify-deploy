<?php

namespace App\Domain\Service;

use App\Domain\Entity\Teacher;
use App\Domain\Model\CreateTeacherModel;
use App\Domain\Model\GetTeacherModel;
use App\Domain\Model\UpdateLoginTeacherModel;
use App\Infrastructure\Repository\TeacherRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TeacherService
{
    public function __construct(
        private readonly TeacherRepository $teacherRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher
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

    public function findAll(): array
    {
        return $this->teacherRepository->findAll();
    }

    public function updateLogin(Teacher $teacher, UpdateLoginTeacherModel $updateLoginTeacherModel): void
    {
        $this->teacherRepository->updateLogin($teacher, $updateLoginTeacherModel->login);
    }

    public function remove(Teacher $teacher): void
    {
        $this->teacherRepository->remove($teacher);
    }
}