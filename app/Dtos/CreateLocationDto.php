<?php

namespace App\Dtos;

Class CreateLocationDto
{
    public function __construct(
        public readonly string $user_id,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly float $accuracy,
        public readonly string $status,
    ) {}

    /**
     * Return a map of the properties
     * 
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'accuracy' => $this->accuracy,
            'status' => $this->status,
        ];
    }
}

?>