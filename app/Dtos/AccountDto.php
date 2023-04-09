<?php

namespace App\Dtos;

Class AccountDto
{
    public function __construct(
        public readonly string $user_id,
        public readonly string $type,
        public readonly string $tag,
        public readonly string $value,
        public readonly string $status,
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
            'type' => $this->type,
            'tag' => $this->tag,
            'value' => $this->value,
            'status' => $this->status,
        ];
    }
}

?>