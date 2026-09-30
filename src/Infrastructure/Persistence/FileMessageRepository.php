<?php

namespace Paya\Infrastructure\Persistence;

use Paya\Domain\Message\Entity\Message;
use Paya\Domain\Message\Repository\MessageRepositoryInterface;
use Paya\Shared\Exception\DomainException;

class FileMessageRepository implements MessageRepositoryInterface
{

    public function getAllMessages(string $filename): array
    {
        try {
            if (!file_exists(__DIR__ . "//messages//" . $filename)) {
                return [];
            }
            $contents = file_get_contents(__DIR__ . "//messages//" . $filename);
            return explode(PHP_EOL, $contents);
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            throw $exception;
        }
        return [];
    }

    public function saveMessage(string $filename, string $message, int $optLock): void
    {
        try {
            $lastId = $this->getLastId($filename);
            if ($lastId == $optLock) {
                $lastId++;
                $message = $lastId . "#" . $message . PHP_EOL;
                file_put_contents(__DIR__ . "//messages//" . $filename, $message, FILE_APPEND | LOCK_EX);
            } else {
                throw new DomainException("failed to write");
            }
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }

    }

    public function getLastId(string $filename): int
    {
        try {
            $contents = file_get_contents(__DIR__ . "//messages//" . $filename, FILE_APPEND);
            $data = explode(PHP_EOL, $contents);
            if (sizeof($data) <= 1) {
                return 0;
            }
            $lastLine = array_key_last($data);
            if ($data[$lastLine] != "" && str_contains($lastLine, "#")) {
                $lastLine = explode("#", $lastLine);
                return $lastLine[0];
            } else {
                $lastLine = $data[$lastLine - 1];
                $lastLine = explode("#", $lastLine);
                return $lastLine[0];
            }
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            throw $exception;
        }
    }

    public function getFilename(string $sender, string $receiver): string
    {
        if (strlen($sender) > strlen($receiver)) {
            return $sender . "_" . $receiver . ".txt";
        } elseif (strlen($sender) < strlen($receiver)) {
            return $receiver . "_" . $sender . ".txt";
        } else {
            $senderRank = 0;
            $receiverRank = 0;
            for ($i = 0; $i < strlen($sender); $i++) {
                if ($sender[$i] > $receiver[$i]) {
                    $senderRank++;
                } elseif ($sender[$i] < $receiver[$i]) {
                    $receiverRank++;
                }
            }
            if ($senderRank > $receiverRank) {
                return $sender . "_" . $receiver . ".txt";
            } elseif ($senderRank < $receiverRank) {
                return $receiver . "_" . $sender . ".txt";
            } else {
                throw new \Exception("bad pattern");
            }
        }
    }

    public function hydrate(array $data): Message
    {
        return new Message($data["id"], $data["message"], $data["sender"], $data["date"]);
    }
}