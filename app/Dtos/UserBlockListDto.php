<?php

namespace App\Dtos;

Class UserBlockListDto
{
    public function __construct(
        public readonly string $user_id,
        public readonly string $blocked_user_id,
    ) {}

    /**
     * Return a map of the properties
     * 
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'blocked_user_id' => $this->blocked_user_id,
        ];
    }
}

?>