<?php
declare(strict_types=1);

namespace Paya\Domain\Message\Entity;

class Message
{
    private ?int $id;
    private string $message;
    private string $sender;
    private string $date;

    public function __construct(?int $id, string $message, string $sender, string $date)
    {
        $this->id = $id;
        $this->message = $message;
        $this->sender = $sender;
        $this->date = $date;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(): void
    {
        $this->date = (new \DateTime())->format("Y-m-d H:i:s");
    }

}