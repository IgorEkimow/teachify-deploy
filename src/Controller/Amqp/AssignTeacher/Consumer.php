<?php

namespace App\Controller\Amqp\AssignTeacher;

use App\Application\RabbitMq\AbstractConsumer;
use App\Controller\Amqp\AssignTeacher\Input\Message;
use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly GroupService $groupService
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
        $group = $this->groupService->find($message->id);

        if (!($group instanceof Group)) {
            return $this->reject(sprintf('Group ID %s was not found', $group->getId()));
        }

        $this->groupService->assignTeacher($group);

        return self::MSG_ACK;
    }
}