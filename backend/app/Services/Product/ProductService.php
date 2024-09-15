<?php
namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\FileUploader\FileUploaderService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductService 
{
    private $service;

    public function __construct(FileUploaderService $service)
    {
        $this->service = $service;
    }
    
    public function index()
    {
        try {
            $products = Product::all(['id', 'name', 'category', 'description', 'date_and_time']);

            return response()->json($products, 200);

        } catch(\Throwable $th) {
            info('Error getting product: ' . $th->getMessage());
            return response()->json(['errors' => 'Server Error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with('images')
                        ->where('id', $id)
                        ->select('id', 'name', 'category', 'description', 'date_and_time')
                        ->first();

            $images = $product->images;

            $imagesURL = [];

            foreach ($images as $image) {
                array_push($imagesURL, url('/storage/'. $image->file_path));
            }

            $productAndImage = [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'description' => $product->description,
                'date_and_time' => $product->date_and_time,
                'images' => $imagesURL
            ];

            return response()->json($productAndImage, 200);

        } catch(\Throwable $th) {
            info('Error getting product: ' . $th->getMessage());
            return response()->json(['errors' => 'Server Error'], 500);
        }
    }

    public function store($request)
    {
        try {
            $product = Product::create([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                'date_and_time' => empty($request->dateAndTime) ? null : $request->dateAndTime,
            ]);

            $productId = $product->id;

            if (is_array($request->product_image)) {

                foreach ($request->product_image as $image) {

                    $productImage = $this->service->saveFile($productId, $image);

                    if (!empty($productImage) || $productImage !== '') {
                        ProductImage::create([
                            'product_id' => $productId,
                            'file_path' => $productImage
                        ]);
                    }
                }

            }

            return response()->json(['message' => 'Product successfully created.'], 201);
            
        } catch(ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
            
        } catch (\Throwable $th) {
            info('Error storing Product: ' . $th->getMessage());
            return response()->json(['errors' => 'Server Error'], 500);
        }
    }

    public function update($request, Product $product)
    {
        try {
            $product->update([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                'date_and_time' => $request->dateAndTime,
            ]);

            $productId = $product->id;

            $productImages = $product->images;

            $images = $productImages->pluck('file_path')->toArray();

            $uploadedFiles = [];

            if (is_array($request->product_image)) {
                
                foreach ($request->product_image as $image) {
                
                    if (str_contains($image, 'storage') !== true) {

                        $productImage = $this->service->saveFile($productId, $image);

                        if (!empty($productImage) || $productImage !== '') {
                            ProductImage::create([
                                'product_id' => $productId,
                                'file_path' => $productImage
                            ]);

                            $uploadedFiles[] = $productImage;
                        }

                    } else {

                        $path = explode("/storage/", $image);

                        $existingFile = $path[1];

                        $uploadedFiles[] = $existingFile;
                        
                    }

                }

                $allFiles = array_diff($images, $uploadedFiles);

                foreach ($allFiles as $file) {
                    if (Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                    }
                }

                ProductImage::whereNotIn('file_path', $uploadedFiles)
                            ->where('product_id', $productId)->delete();

            }

            return response()->json(['message' => 'Product successfully updated.'], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);

        } catch (\Throwable $th) {
            info('Error updating Product: ' . $th->getMessage());
            return response()->json(['errors' => 'Server Error'], 500);
        }
    }

    public function delete($product)
    {
        try {
            $directory = 'uploads/products/'. $product->id;

            info($directory);
    
            if (Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->deleteDirectory($directory);
                $product->images()->delete();
            }
    
            $product->delete();

            return response()->json(['message' => 'Product successfully deleted.'], 200);

        }  catch (\Throwable $th) {
            info('Error deleting Product: ' . $th->getMessage());
            return response()->json(['errors' => 'Server Error'], 500);
        }
    }
}