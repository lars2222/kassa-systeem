<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UpdateProductRequest as ProductUpdateProductRequest;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository, $categoryRepository;


    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;  
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getAllPaginated();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->getAllPaginated();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->all());

        return redirect()->route('products.index')->with('success', __('labels.added'));
    }

    public function edit(Product $product)
    {

        return view('admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        $update = $request->only($product->getFillable());

        $this->productRepository->update($product->id, $update, 'product');

        return redirect()->route('products.index')->with('success', __('labels.added'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
