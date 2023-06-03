<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Allergy;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): ProductCollection
    {
        return new ProductCollection(
            Product::when($request->has('search'), fn ($query) => $query->where('name', 'like', "%{$request->get('search')}%"))
            ->paginate($request->get('per_page', 10))
        );
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function filters(): JsonResponse
    {
        return response()->json([
            'data' => [
                [
                    'title' => 'Categories',
                    'data' => ProductCategory::whereHas('products')->get()->map(function (ProductCategory $category) {
                        return [
                            'name' => $category->name,
                            'uuid' => $category->external_id,
                        ];
                    })->toArray(),
                ],
                [
                    'title' => 'Allergies',
                    'data' => Allergy::whereHas('products')->get()->map(function (Allergy $allergy) {
                        return [
                            'name' => $allergy->name,
                            'uuid' => $allergy->external_id,
                        ];
                    })->toArray(),
                ],
            ],
        ]);
    }
}
