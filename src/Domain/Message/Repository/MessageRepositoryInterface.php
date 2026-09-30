<?php
declare(strict_types=1);

namespace Paya\Domain\Message\Repository;

use Paya\Domain\Message\Entity\Message;

interface MessageRepositoryInterface
{
    public function getAllMessages(string $filename): array;

    public function saveMessage(string $filename, string $message, int $optLock): void;

    public function getLastId(string $filename): int;

    public function getFilename(string $sender, string $receiver): string;

    public function hydrate(array $data): Message;
}