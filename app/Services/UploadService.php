<?php

namespace App\Services;

use App\Dtos\CreateUploadDto;
use App\Interfaces\IUploadProvider;
use App\Models\Upload;
use App\Repositories\UploadRepository;

class UploadService
{
    public function __construct(
        private readonly UploadRepository $uploadRepository,
        private readonly IUploadProvider $uploadProvider
    ) {}

    public function upload(CreateUploadDto $uploadDto): Upload
    {
        /**
         * @var string $fileUrl
         */
        $fileUrl = $this->uploadProvider->upload(
            $uploadDto->file->getPathname(),
            $uploadDto->file->getMimeType()
        );
        
        /**
         * @var Upload
         */
        return $this->uploadRepository->create([
            "user_id" => $uploadDto->user_id,
            "tag" => $uploadDto->tag,
            "value" => $fileUrl,
        ]);
    }

    public function getSignedUrl(string $mimeType): string
    {
        return $this->uploadProvider->getSignedUrl($mimeType);
    }
}

?>