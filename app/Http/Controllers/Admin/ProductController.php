<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\DiscountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository, $categoryRepository, $discountRepository;


    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, DiscountRepository $discountRepository)
    {
        $this->productRepository = $productRepository;  
        $this->categoryRepository = $categoryRepository;
        $this->discountRepository = $discountRepository;
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

    public function discountProduct()
    {
        $products = $this->productRepository->getAllPaginated();

        $discounts = $this->discountRepository->getAllPaginated();

        return view('admin.products.discount-products', compact('products','discounts'));
    }

    public function addDiscount(Request $request, $productId)
    {
        $request->validate([
            'discount_id' => 'required|exists:discounts,id',
        ]);
    
        $product = Product::findOrFail($productId);

        if ($product->discounts()->exists()) {
            return redirect()->route('products.discount-products')->with('error', 'Dit product heeft al een korting.');
        }
    
        $discountId = $request->input('discount_id');

        $product->discounts()->attach($discountId);
    
        return redirect()->route('products.discount-products')->with('success', 'Korting succesvol toegevoegd aan product.');
    }

    public function removeDiscount($productId, $discountId)
    {
        $product = Product::findOrFail($productId);

        $product->discounts()->detach($discountId);

        return redirect()->route('products.discount-products')->with('success', 'Korting succesvol verwijderd van product.');
    }
   

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
