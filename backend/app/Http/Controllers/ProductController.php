<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Termék nem található'], 404);
        }
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}