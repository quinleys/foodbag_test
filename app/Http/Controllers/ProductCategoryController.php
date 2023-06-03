<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCategoryCollection;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(Request $request): ProductCategoryCollection
    {
        return new ProductCategoryCollection(
            ProductCategory::paginate($request->get('per_page', 10))
        );
    }

    public function show(ProductCategory $category): ProductCategoryResource
    {
        return new ProductCategoryResource($category);
    }
}
