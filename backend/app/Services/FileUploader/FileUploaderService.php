<?php
namespace App\Services\FileUploader;

use Illuminate\Support\Facades\Storage;

class FileUploaderService {

    public function upload($request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');

            return response()->json(['file_path' => '/storage/' . $filePath], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function revert($request)
    {
        $request->validate([
            'file_path' => 'required|string',
        ]);

        $filePath = str_replace('/storage/', '', $request->file_path);

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->json(['message' => 'File removed successfully'], 200);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}