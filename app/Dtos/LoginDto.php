<?php

namespace App\Dtos;

class LoginDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    /**
     * Return a map of the properties
     * 
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
