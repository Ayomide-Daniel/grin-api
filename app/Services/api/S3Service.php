<?php

namespace App\Services;

use App\Interfaces\IUploadProvider;
use Aws\S3\S3Client;

class S3Service implements IUploadProvider
{
    /**
     * @var S3Client
     */
    private $S3;

    public function __construct()
    {
        $this->S3 = new S3Client([
            'region' => config("grin.aws.region"),
            'version' => 'latest',
            'credentials' => [
                'key'    => config("grin.aws.key"),
                'secret' => config("grin.aws.secret"),
            ]
        ]);
    }

    private function createDestinationPath(string $file_name): string
    {
        $timestamp = time();

        //files are shelved in {{upload_dir}}/yyyy/mm/file_name.ext
        // $path = '';
        $shelf = date('Y/m/', $timestamp); //->yyyy/mm/

        //create the destination path
        $path = $shelf . $file_name;

        return $path;
    }

    public function upload(string $tempFilePath, string $mimeType): string
    {
        $destinationPath = $this->createDestinationPath($this->generateFileName());

        $this->S3->putObject([
            'Bucket' => config("grin.aws.bucket"),
            'Key'    => $destinationPath,
            'SourceFile' => $tempFilePath,
            'CacheControl' => "no-cache",
            'ContentType' => $mimeType,
        ]);

        return config("grin.cloudfront_url") . "/" . $destinationPath;
    }

    public function getSignedUrl(string $mimeType): string
    {
        $destinationPath = $this->createDestinationPath($this->generateFileName());

        $command = $this->S3->getCommand('PutObject', [
            'Bucket' => config("grin.aws.bucket"),
            'Key' => $destinationPath,
            'ContentType' => $mimeType,
        ]);

        $request = $this->S3->createPresignedRequest($command, '+5 minutes');

        // Get the actual presigned-url
        $presignedUrl = (string) $request->getUri();

        return $presignedUrl;
    }

    private function generateFileName(): string
    {
        // generate random bytes
        $randomBytes = random_bytes(16);

        // convert to hex
        $hex = bin2hex($randomBytes);

        // generate random file name
        $fileName = $hex;

        return $fileName;
    }
}
