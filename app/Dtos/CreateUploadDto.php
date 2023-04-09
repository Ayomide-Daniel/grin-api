<?php

namespace App\Dtos;

use Illuminate\Http\UploadedFile;

Class CreateUploadDto
{
    public function __construct(
        public readonly string $user_id,
        public readonly UploadedFile $file,
        public readonly string $tag,
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
            'file' => $this->file,
            'tag' => $this->tag,
        ];
    }
}

?>