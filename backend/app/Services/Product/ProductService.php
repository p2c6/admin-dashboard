<?php
namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Validation\ValidationException;

class ProductService 
{
    public function store($request)
    {
        try {
            $product = Product::create([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->name,
                'date_and_time' => $request->dateAndTime,
            ]);

            return response()->json(['message' => 'Product successfully created.'], 201);
            
        } catch(ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
            
        } catch (\Throwable $th) {
            info('Error storing Product: ' . $th->getMessage());
            return response()->json(['errors' => 'Server Error'], 500);
        }
    }

    public function update($request)
    {

    }
}