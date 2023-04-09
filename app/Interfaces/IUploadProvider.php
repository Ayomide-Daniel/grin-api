<?php

namespace App\Interfaces;

interface IUploadProvider
{
    public function upload(string $tempFilePath, string $mimeType): string;

    public function getSignedUrl(string $mimeType): string;
}

?>