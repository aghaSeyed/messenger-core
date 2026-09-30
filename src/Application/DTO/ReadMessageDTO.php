<?php

declare(strict_types=1);

namespace Paya\Application\DTO;

use Paya\Shared\Exception\ValidationException;

class ReadMessageDTO
{
    public string $username;
    public string $password;
    public string $partner;

    public function __construct(string $username, string $password, string $partner)
    {
        $this->username = $username;
        $this->password = $password;
        $this->partner = $partner;
    }

    public static function fromArray(array $data)
    {
        if (!isset($data['username'])) {
            throw ValidationException::missingField('username');
        }

        if (!isset($data['password'])) {
            throw ValidationException::missingField('password');
        }


        if (!isset($data['partner'])) {
            throw ValidationException::missingField('partner');
        }


        return new self(
            trim($data['username']),
            trim($data['password']),
            trim($data['partner']),
        );
    }
}