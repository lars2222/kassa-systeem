<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
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

        $transaction = Transaction::create([
            'user_id' => 1, 
            'subtotal' => $totalAmount,
            'total' => $totalAmount, 
            'tax' => 0, 
        ]);

        $payment = Payment::create([
            'transaction_id' => $transaction->id,
            'amount' => $totalAmount,
            'method' => $request->payment_method,
            'cash_received' => $request->payment_method === 'cash' ? $cashReceived : null,
            'change_given' => $change,
        ]);

        foreach ($cart as $item) {
            if (isset($item['product'])) { 
                $productId = $item['product']->id; 
                $transaction->products()->attach($productId, [
                    'quantity' => $item['quantity'], 
                    'price_at_time' => $item['product']->price, 
                    'total' => $item['quantity'] * $item['product']->price, 
                    'discount_applied' => $item['discount'] ?? 0, 
                ]);
            }    
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
