<?php

namespace App\Controller\Amqp\AssignGroup;

use App\Application\RabbitMq\AbstractConsumer;
use App\Controller\Amqp\AssignGroup\Input\Message;
use App\Domain\Entity\Student;
use App\Domain\Service\StudentService;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly StudentService $studentService
    ) {
    }

    protected function getMessageClass(): string
    {
        return Message::class;
    }

    /**
     * @param Message $message
     */
    protected function handle($message): int
    {
        $student = $this->studentService->find($message->id);

        if (!($student instanceof Student)) {
            return $this->reject(sprintf('Student ID %s was not found', $student->getId()));
        }

        $this->studentService->assignToGroup($student, $student->getSkills()->toArray());

        return self::MSG_ACK;
    }
}