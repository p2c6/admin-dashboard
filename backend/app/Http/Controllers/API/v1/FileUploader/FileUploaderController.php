<?php

namespace App\Http\Controllers\API\v1\FileUploader;

use App\Http\Controllers\Controller;
use App\Services\FileUploader\FileUploaderService;
use Illuminate\Http\Request;

class FileUploaderController extends Controller
{
    private $service;

    public function __construct(FileUploaderService $service)
    {
        $this->service = $service;
    }

    public function upload(Request $request)
    {
        return $this->service->upload($request);
    }

    public function revert(Request $request)
    {
        return $this->service->revert($request);
    }
}
