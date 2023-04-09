<?php

namespace App\Dtos;

Class FriendRequestDto
{
    public function __construct(
        public readonly string $sender_id,
        public readonly string $receiver_id,
    ) {}

    /**
     * Return a map of the properties
     * 
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
        ];
    }
}

?>