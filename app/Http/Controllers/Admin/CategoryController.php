<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;  
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAllPaginated();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        if (Category::where('name', $request->name)->exists()) {
            return redirect()->back()->withErrors(['name' => __('labels.category_exists')]);
        }

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', __('labels.added'));
    }


    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $update = $request->only($category->getFillable());

        $this->categoryRepository->update($category->id, $update, 'category');

        return redirect()->route('categories.index')->with('success', __('labels.added'));
    }

    public function show($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        $categories = Category::all(); 
        $category = Category::find($categoryId); 
        
        return view('client.webshop.products', compact('products', 'categories', 'category'));
    }
    
    
    
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
