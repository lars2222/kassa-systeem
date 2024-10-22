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
        $this->cart = new Cart(); // Maak een nieuw Cart-object
    }

    public function addToCart(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1); // Default naar 1 als geen hoeveelheid is opgegeven
        $this->cart->addProduct($productId, $quantity);
        
        return redirect()->back()->with('success', 'Product toegevoegd aan je winkelwagentje!');
    }

    public function removeFromCart($productId)
    {
        $this->cart->removeProduct($productId);
        
        return redirect()->back()->with('success', 'Product verwijderd uit je winkelwagentje!');
    }

    public function updateCart(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1); 
    
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        $this->cart->updateQuantity($productId, $quantity);
        
        return redirect()->route('cart.view')->with('success', 'Aantal bijgewerkt!');
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
