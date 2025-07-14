<?php

namespace App\Domain\Service;

use App\Domain\Bus\AssignGroupBusInterface;
use App\Domain\DTO\AssignGroupDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\Student;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Model\GetStudentModel;
use App\Domain\Model\GroupMatchingCriteria;
use App\Domain\Model\UpdateLoginStudentModel;
use App\Infrastructure\Repository\GroupRepository;
use App\Infrastructure\Repository\StudentRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Infrastructure\Repository\StudentRepositoryCacheDecorator;

class StudentService implements UserServiceInterface
{
    public function __construct(
        private readonly StudentRepository $studentRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly StudentRepositoryCacheDecorator $cacheDecorator,
        private readonly GroupRepository $groupRepository,
        private readonly AssignGroupBusInterface $assignGroupBus,
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

    public function find($id): ?Student
    {
        return $this->studentRepository->find($id);
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

    public function assignToGroup(Student $student, array $requiredSkills): ?Group
    {
        $criteria = new GroupMatchingCriteria(requiredSkills: $requiredSkills, maxGroupSize: 20, maxIrrelevantSkillRatio: 0.3, maxUnwantedSkillsRatio: 0.5);

        $groupMatcher = new GroupMatcherService($this->groupRepository);
        $bestGroup = $groupMatcher->findBestMatchForStudent($student, $criteria);

        if ($bestGroup) {
            $bestGroup->addStudent($student);
            $this->groupRepository->update($bestGroup);
            $this->cacheDecorator->clearCache();
        }

        return $bestGroup;
    }

    public function assignGroupAsync(AssignGroupDTO $assignGroupDTO)
    {
        return $this->assignGroupBus->sendAssignGroupMessage($assignGroupDTO);
    }
}