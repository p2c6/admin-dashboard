<?php
namespace App\Services\FileUploader;

use App\Models\ProductImage;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploaderService {

    public function upload($request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $uuid = (string) Str::uuid();
            $fileName = $uuid . '.' . $extension;

            $directoryPath = 'uploads/temporary/' . $uuid;

            $file->storeAs($directoryPath, $fileName, 'public');

            try {
                TemporaryFile::create([
                    'original_name' => $originalName,
                    'file_name' => $fileName,
                    'directory_path' => $directoryPath
                ]);

                return response()->json(['file_path' => $uuid], 200);
                
            } catch(\Throwable $th) {
                info('Error storing to temporary file' . $th->getMessage());
                return response()->json(['message' => 'Server Error'], 500);
            }

        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function revert($request)
    {
        $request->validate([
            'file_path' => 'required|string',
        ]);
        
        $directoryPath = 'uploads/temporary/' . $request->file_path;
        
        if (Storage::disk('public')->exists($directoryPath)) {
            Storage::disk('public')->deleteDirectory($directoryPath);

            TemporaryFile::where('directory_path', $directoryPath)->delete();

            return response()->json(['message' => 'Directory and its files removed successfully'], 200);
        }
        
        return response()->json(['error' => 'Directory not found'], 404);
    }

    public function saveFile($productId, $directoryPath)
    {
        try {
            
            $appendedDirectoryPath = 'uploads/temporary/' . $directoryPath;

            $temporaryFile = TemporaryFile::where('directory_path', $appendedDirectoryPath)->first();

            if ($directoryPath) {

                $tempDirectoryPath = $temporaryFile->directory_path;
                $fileName = $temporaryFile->file_name;
                $file = $tempDirectoryPath . '/' . $fileName;

                $permanentPath = 'uploads/products/' . $productId . '/' . $fileName;

                Storage::disk('public')->move($file, $permanentPath);

                Storage::disk('public')->deleteDirectory($appendedDirectoryPath);

                return $permanentPath;
            }

            return '';

        } catch (\Throwable $th) {
            info('Error moving product image: ' . $th->getMessage());
        }
    }
}