<?php

namespace Paya\Application\UseCase;

use Paya\Application\DTO\ReadMessageDTO;
use Paya\Domain\Message\Repository\MessageRepositoryInterface;
use Paya\Shared\Exception\AuthException;

class ReadMessageRequest
{
    private MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function execute(ReadMessageDTO $request)
    {
        $messages = [];
        if ($request->password != 'sun-strike') {
            throw new AuthException("incorrect password");
        }
        $filename = $this->messageRepository->getFilename($request->username, $request->partner);

        $contents = $this->messageRepository->getAllMessages($filename);
        foreach ($contents as $message) {
            $message = trim($message);
            $data = explode("#", $message);
            if (!empty($data) && sizeof($data) > 1) {
                $id = $data[0];
                $decoded = $data[1];
                $messageData = json_decode($decoded, true);
                $messageData['id'] = $id;
                $messages[$id] = $messageData;
            }
        }

        return $messages;
    }
}