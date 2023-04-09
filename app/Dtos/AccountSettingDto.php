<?php

namespace App\Dtos;

Class AccountSettingDto
{
    public function __construct(
        public readonly string $user_id,
        public readonly string $tag,
        public readonly string $value,
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
            'tag' => $this->tag,
            'value' => $this->value,
        ];
    }
}

?>