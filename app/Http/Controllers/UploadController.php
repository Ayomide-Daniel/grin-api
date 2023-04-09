<?php

namespace App\Http\Controllers;

use App\Dtos\CreateUploadDto;
use App\Http\Requests\UploadRequest;
use App\Services\UploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct(
        private readonly UploadService $uploadService,
    ) {
    }

    /**
     * Upload file
     */
    public function upload(UploadRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(["user_id", "file", "tag"]);

        $upload = $this->uploadService->upload(new CreateUploadDto(
            $validated["user_id"],
            $validated["file"],
            $validated["tag"]
        ));

        return response()->json([
            'message' => 'File was uploaded successfully',
            'data' => $upload
        ], 201);
    }

    /**
     * Get signed url
     */
    public function getSignedUrl(Request $request): JsonResponse
    {
        $request->validate([
            "mimeType" => "required|string|in:image/png,image/jpeg,image/jpg,image/gif,image/webp",
        ]);

        $mimeType = $request->input("mimeType");

        $signedUrl = $this->uploadService->getSignedUrl($mimeType);

        return response()->json([
            'message' => 'Signed URL was generated successfully',
            'url' => $signedUrl
        ], 200);
    }
}
