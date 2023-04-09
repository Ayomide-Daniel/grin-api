<?php

namespace App\Dtos;

class RegisterDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $gender,
        public readonly string $country,
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
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'country' => $this->country,
            'password' => $this->password,            
        ];
    }
}
