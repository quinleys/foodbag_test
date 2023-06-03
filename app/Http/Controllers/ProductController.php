<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): ProductCollection
    {
        return new ProductCollection(
            Product::paginate($request->get('per_page', 10))
        );
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
