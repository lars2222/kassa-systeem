<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;

    public function __construct()
    {
        $this->cart = new Cart(); 
    }

    public function addToCart(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1); 
        $this->cart->addProduct($productId, $quantity);
        
        return redirect()->back()->with('success', 'Product toegevoegd aan je winkelwagentje!');
    }

    public function removeFromCart($productId)
    {
        $this->cart->removeProduct($productId);
        
        return response()->json(['success' => true]);
    }

    public function updateCart(Request $request, $productId)
    {
        $quantity = $request->input('quantity');
    
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        $this->cart->updateQuantity($productId, $quantity);
    
        $product = Product::find($productId);
        return response()->json(['price' => $product->price]);
    }

    public function viewCart()
    {
        $cart = $this->cart->getCart(); 
        $total = $this->cart->calculateTotal(); 
    
        $categories = Category::take(6)->get(); 
        
        $products = Product::all();
    
        return view('client.shopping-cart.index', compact('cart', 'total', 'categories', 'products'));
    }

    public function checkout()
    {
        $this->cart->emptyCart();
        
        return redirect()->route('home')->with('success', 'Bedankt voor je bestelling!');
    }
}
