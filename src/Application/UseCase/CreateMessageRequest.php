<?php

namespace Paya\Application\UseCase;

use Paya\Application\DTO\MessageDTO;
use Paya\Domain\Message\Repository\MessageRepositoryInterface;
use Paya\Shared\Exception\AuthException;

class CreateMessageRequest
{
    private MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function execute(MessageDTO $messageDTO): void
    {
        if ($messageDTO->password != 'sun-strike') {
            throw new AuthException("incorrect password");
        }
        $encoded = json_encode($messageDTO->toArray(), true);
        $filename = $this->messageRepository->getFilename($messageDTO->sender, $messageDTO->receiver);
        $lastId = $this->messageRepository->getLastId($filename);
        $this->messageRepository->saveMessage($filename, $encoded, $lastId);
    }

}