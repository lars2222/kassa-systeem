<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Inventories\UpdateInventoryRequest;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Models\Inventory;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\DiscountRepository;
use App\Repositories\InventoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TaxRateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productRepository, $categoryRepository, $discountRepository, $inventoryRepository, $taxRateRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, DiscountRepository $discountRepository, InventoryRepository $inventoryRepository, TaxRateRepository $taxRateRepository)
    {
        $this->productRepository = $productRepository;  
        $this->categoryRepository = $categoryRepository;
        $this->discountRepository = $discountRepository;
        $this->inventoryRepository = $inventoryRepository;
        $this->taxRateRepository = $taxRateRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getAllPaginated();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->getAllPaginated();
        $taxRates = $this->taxRateRepository->getAllPaginated();

        return view('admin.products.create', compact('categories','taxRates'));
    }

    public function store(StoreProductRequest $request)
    {
        $products = $request->validated(); 

        if (Product::where('barcode', $products['barcode'])->exists()) {
            return redirect()->back()->withErrors(['barcode' => __('labels.barcode_exists')]);
        }
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $products['image'] = $imagePath;
        }

        Product::create($products);
    
        return redirect()->route('products.index')->with('success', __('labels.added'));
    }

    public function edit(Product $product)
    {
        $taxRates = $this->taxRateRepository->getAllPaginated();
        $categories = $this->categoryRepository->getAllPaginated();
    
        return view('admin.products.edit', compact('product', 'categories', 'taxRates'));
    }
    
    public function update(UpdateProductRequest $request, Product $product)
    {
        $products = $request->validated();
    
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image); 
            }
    
            $imagePath = $request->file('image')->store('products', 'public');
            $products['image'] = $imagePath; 
        }
    
        $product->update($products);
    
        return redirect()->route('products.index')->with('success', __('labels.updated'));
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

    public function productStock()
    {
        $products = Product::with('inventory')->get();
        return view('admin.products.product-stock', compact('products'));
    }

    public function updateStock(UpdateInventoryRequest $request, Product $product)
    {
        $validatedData = $request->validated();
        $quantity = $validatedData['quantity'];
        $operation = $validatedData['operation'];

        $inventory = $product->inventory()->first();

        if ($inventory) {
            $inventory->quantity += ($operation === 'add' ? $quantity : -$quantity);
            $inventory->quantity = max(0, $inventory->quantity); 
            $inventory->save();
        } else {
            Inventory::create([
                'product_id' => $product->id,
                'quantity' => max(0, ($operation === 'add' ? $quantity : 0)),
                'minimum_stock' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Voorraad bijgewerkt!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
    
        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get();
    
        $categories = $this->categoryRepository->getAllPaginated();
        return view('client.partials.product-list', compact('products', 'categories'));
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
