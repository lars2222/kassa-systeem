<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
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

    public function emptyCart()
    {
        $this->cart->emptyCart(); 
        
        return redirect()->route('cart.view')->with('success', 'Je winkelwagen is geleegd');
    }

    public function checkout(Request $request)
    {
        $cart = $this->cart->getCart();
        $totalAmount = $this->cart->getTotal(); 

        $change = 0.0; 
        if ($request->payment_method === 'cash') {
            $cashReceived = $request->input('cash_received');
            if ($cashReceived < $totalAmount) {
                return redirect()->back()->withErrors(['cash_received' => 'Het ontvangen bedrag is niet voldoende om de bestelling te betalen.']);
            }
            $change = floatval($cashReceived) - floatval($totalAmount); 
        }

        $this->cart->emptyCart();

        return redirect()->route('cart.reciept')->with([
            'success' => 'Bedankt voor je bestelling!',
            'cart' => $cart,
            'change' => number_format($change, 2, ',', '.'), 
        ]);
    }

    public function reciept()
    {
        $change = session('change', 0);
        return view('client.shopping-cart.reciept', ['change' => $change]);
    }

}
