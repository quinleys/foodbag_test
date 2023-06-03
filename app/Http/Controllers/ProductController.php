<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Allergy;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): ProductCollection
    {
        return new ProductCollection(
            Product::
                with(['productCategories', 'media'])
                ->when($request->has('search'), fn($query) => $query->where('name', 'like', "%{$request->get('search')}%"))
                ->when($request->has('categories'), fn($query) => $query->with('productCategories')->whereHas('productCategories', fn($query) => $query->whereIn('slug', Str::of($request->get('categories'))->explode(','))))
                ->when($request->has('allergies'), fn($query) => $query->with('allergies')->whereHas('allergies', fn($query) => $query->whereIn('slug', Str::of($request->get('allergies'))->explode(','))))
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
                            'slug' => $category->slug,
                            'uuid' => $category->external_id,
                        ];
                    })->toArray(),
                ],
                [
                    'title' => 'Allergies',
                    'data' => Allergy::whereHas('products')->get()->map(function (Allergy $allergy) {
                        return [
                            'name' => $allergy->name,
                            'slug' => $allergy->slug,
                            'uuid' => $allergy->external_id,
                        ];
                    })->toArray(),
                ],
            ],
        ]);
    }
}
