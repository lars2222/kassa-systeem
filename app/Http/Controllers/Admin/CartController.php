<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Checkout\CheckoutRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
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

    public function checkout(CheckoutRequest $request)
    {
        $cart = $this->cart->getCart(); 
        $totalAmount = $this->cart->getTotal(); 

        // Verwerk betaling en bepaal wisselgeld
        $change = $this->processPayment($request, $totalAmount);

        // Maak transactie aan
        $transaction = $this->createTransaction($totalAmount);

        // Voeg producten toe aan de transactie
        $this->attachProductsToTransaction($transaction, $cart);

        // Afronding: voorraad, winkelwagen legen, sessie bijwerken
        $this->finalizeOrder($transaction->id, $cart);

        return redirect()->route('cart.receipt')->with([
            'success' => 'Bedankt voor je bestelling! Je kassabon is beschikbaar als PDF.',
            'cart' => $cart,
            'change' => number_format($change, 2, ',', '.'),
        ]);
    }

    private function processPayment($request, $totalAmount)
    {
        $change = 0.0;

        if ($request->payment_method === 'cash') {
            $cashReceived = $request->input('cash_received');
            if ($cashReceived < $totalAmount) {
                redirect()->back()->withErrors(['cash_received' => 'Het ontvangen bedrag is niet voldoende om de bestelling te betalen.']);
            }
            $change = floatval($cashReceived) - floatval($totalAmount); 
        } elseif ($request->payment_method === 'pin') {
            // Eventuele logica voor pinbetaling
        }

        return $change;
    }

    private function createTransaction($totalAmount)
    {
        return Transaction::create([
            'user_id' => 1,
            'subtotal' => $totalAmount,
            'total' => $totalAmount, 
            'tax' => 0, 
        ]);
    }

    private function attachProductsToTransaction($transaction, $cart)
    {
        foreach ($cart as $item) {
            if (isset($item['product'])) { 
                $productId = $item['product']->id; 
                $quantity = $item['quantity']; 

                $transaction->products()->attach($productId, [
                    'quantity' => $quantity, 
                    'price_at_time' => $item['product']->price, 
                    'total' => $quantity * $item['product']->price, 
                    'discount_applied' => $item['discount'] ?? 0, 
                ]);
            }    
        }
    }
    
    private function finalizeOrder($transactionId, $cart)
    {
        $this->updateInventory($cart);       
        $this->cart->emptyCart();           
        session(['transaction_id' => $transactionId]); 
    }

    protected function updateInventory($cart)
    {
        foreach ($cart as $item) {
            if (isset($item['product'])) { 
                $productId = $item['product']->id; 
                $quantity = $item['quantity']; 

                $product = Product::find($productId);
                if ($product && $product->inventory) {
                    $product->inventory->quantity -= $quantity; 
                    $product->inventory->save();
                }
            }
        }
    }

    public function chooseReceiptOption()
    {
        $change = session('change', 0);
        return view('client.shopping-cart.reciept', ['change' => $change]);
    }

    public function handleReceiptOption(Request $request)
    {
        $receiptOption = $request->input('receiptOption');

        $transactionId = session('transaction_id');

        if($receiptOption === 'print'){
            return redirect()->route('receipt.generatePdf', ['transactionId' => $transactionId]);
        }

        return redirect()->route('cart.view')->with('success', 'Gefeliciteerd met je bestelling');
    }
}
