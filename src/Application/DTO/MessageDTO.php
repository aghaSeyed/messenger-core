<?php

declare(strict_types=1);

namespace Paya\Application\DTO;

use Paya\Shared\Exception\ValidationException;

class MessageDTO
{
    public string $message;
    public string $sender;
    public string $receiver;
    public string $date;
    public string $password;

    public function __construct(string $message, string $sender, string $date, string $receiver , string $password)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->password = $password;
        $this->date = $date;
    }

    public static function fromArray(array $data)
    {
        if (!isset($data['message'])) {
            throw ValidationException::missingField('message');
        }

        if (!isset($data['password'])) {
            throw ValidationException::missingField('password');
        }

        if (!isset($data['sender'])) {
            throw ValidationException::missingField('sender');
        }

        if (!isset($data['receiver'])) {
            throw ValidationException::missingField('receiver');
        }

        return new self(
            trim($data['message']),
            trim($data['sender']),
            (new \DateTime())->format('Y-m-d H:i:s'),
            trim($data['receiver']),
            trim($data['password'])
        );

    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'date' => $this->date,
        ];
    }
}