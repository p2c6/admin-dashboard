<?php

namespace App\Http\Controllers\API\v1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function store(StoreProductRequest $request)
    {
        return $this->service->store($request);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        return $this->service->update($request, $product);
    }

    public function delete(Product $product)
    {
        return $this->service->delete($product);
    }
}
