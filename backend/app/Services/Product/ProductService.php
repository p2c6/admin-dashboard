<?php
namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\FileUploader\FileUploaderService;
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
            $products = Product::all(['name', 'category', 'description', 'date_and_time']);

            return response()->json($products, 200);

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
                'date_and_time' => $request->dateAndTime,
            ]);

            $productId = $product->id;

            if (is_array($request->product_images)) {

                foreach ($request->product_images as $image) {

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

            return response()->json(['message' => 'Product successfully updated.'], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);

        } catch (\Throwable $th) {
            info('Error updating Product: ' . $th->getMessage());
            return response()->json(['errors' => 'Server Error'], 500);
        }
    }
}