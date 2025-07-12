<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Model\GetStudentModel;
use App\Domain\Model\UpdateLoginStudentModel;
use App\Infrastructure\Repository\StudentRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Infrastructure\Repository\StudentRepositoryCacheDecorator;

class StudentService implements UserServiceInterface
{
    public function __construct(
        private readonly StudentRepository $studentRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly StudentRepositoryCacheDecorator $cacheDecorator
    ) {
    }

    public function create(CreateStudentModel $createStudentModel): Student
    {
        $student = new Student();
        $student->setName($createStudentModel->name);
        $student->setLogin($createStudentModel->login);
        $student->setPassword($this->userPasswordHasher->hashPassword($student, $createStudentModel->password));
        $student->setRoles($createStudentModel->roles);
        $student->setCreatedAt();
        $student->setUpdatedAt();

        $this->studentRepository->create($student);
        $this->cacheDecorator->clearCache();

        return $student;
    }

    public function findById(GetStudentModel $getStudentModel): ?Student
    {
        return $this->studentRepository->find($getStudentModel->id);
    }

    public function findByLogin(CreateStudentModel $createStudentModel): ?Student
    {
        $student = $this->studentRepository->findByLogin($createStudentModel->login);
        return $student[0] ?? null;
    }

    public function findUserByLogin(string $login): ?Student
    {
        $users = $this->studentRepository->findByLogin($login);

        return $users[0] ?? null;
    }

    public function findUserByToken(string $token): ?Student
    {
        return $this->studentRepository->findByToken($token);
    }

    public function findAll(): array
    {
        return $this->studentRepository->findAll();
    }

    public function updateLogin(Student $student, UpdateLoginStudentModel $updateLoginStudentModel): void
    {
        $this->studentRepository->updateLogin($student, $updateLoginStudentModel->login);
        $this->cacheDecorator->clearCache();
    }

    public function updateUserToken(string $login): ?string
    {
        $user = $this->findUserByLogin($login);
        if ($user === null) {
            return null;
        }

        return $this->studentRepository->updateToken($user);
    }

    public function clearUserToken(string $login): void
    {
        $user = $this->findUserByLogin($login);
        if ($user !== null) {
            $this->studentRepository->clearToken($user);
        }
    }

    public function remove(Student $student): void
    {
        $this->studentRepository->remove($student);
        $this->cacheDecorator->clearCache();
    }
}