<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function itemCategory()
    {
        return Inertia::render('Category/ItemCategory');
    }

    public function showBrands()
    {
        return Inertia::render('Category/Brands');
    }
    public function showSupplier()
    {
        return Inertia::render('Category/Supplier');
    }
}
