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
        
        return response()->noContent();
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

        $total = $this->cart->calculateTotalWithoutDiscount();
        $totalDiscount = $this->cart->calculateTotalDiscount();

        return response()->json([
            'price' => $product->getDiscountedPriceIncludingTax(),
            'total' => $total,
            'totalDiscount' => $totalDiscount,
        ]);
    }

    public function viewCart()
    {
        $cart = $this->cart->getCart(); 
        $total = $this->cart->calculateTotalWithoutDiscount(); 
        $totalDiscount = $this->cart->calculateTotalDiscount(); 

        $categories = Category::take(6)->get(); 
        
        return view('client.shopping-cart.index', compact('cart', 'total', 'categories', 'totalDiscount'));
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
    
        $change = $this->processPayment($request, $totalAmount);
    
        if ($change === false) {
            return redirect()->back(); 
        }
    
        $transaction = $this->createTransaction($totalAmount);
        $this->createPayment($transaction->id, $request, $totalAmount, $change);
        $this->attachProductsToTransaction($transaction, $cart);
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
            $change = $this->processCashPayment($request, $totalAmount);
        } elseif ($request->payment_method === 'card') {
            $change = $this->processPinPayment($request, $totalAmount);
        }
    
        return $change;
    }
    
    private function processCashPayment($request, $totalAmount)
    {
        $cashReceived = $request->input('cash_received');
    
        if ($cashReceived < $totalAmount) {
            session()->flash('error', 'Het ontvangen bedrag is niet voldoende om de bestelling te betalen.');
            return false;
        }
    
        return floatval($cashReceived) - floatval($totalAmount);
    }
    
    private function processPinPayment($request, $totalAmount)
    {   
        $request->merge(['cash_received' => $totalAmount]);
        
        return 0.0; 
    }
    
    private function createTransaction($totalAmount)
    {
        $transaction = Transaction::create([
            'user_id' => 1,
            'subtotal' => $totalAmount,
            'total' => $totalAmount,
            'tax' => 0,
        ]);
    
        return $transaction;
    }
    
    private function attachProductsToTransaction($transaction, $cart)
    {
        foreach ($cart as $item) {
            if (isset($item['product'])) {
                $productId = $item['product']->id;
                $quantity = $item['quantity'];
    
                $transaction->products()->attach($productId, [
                    'quantity' => $quantity,
                    'price_at_time' => $item['product']->getOriginalPriceIncludingTax(),
                    'total' => $quantity * $item['product']->price_including_tax,
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
    
    private function createPayment($transactionId, $request, $totalAmount, $change)
    {
        Payment::create([
            'transaction_id' => $transactionId,
            'amount' => $totalAmount,
            'method' => $request->input('payment_method'),
            'cash_received' => floatval($request->input('cash_received')),
            'change_given' => $change,
        ]);
    }
    
    public function chooseReceiptOption()
    {
        $change = session('change', 0);
        return view('client.shopping-cart.receipt', ['change' => $change]);
    }


    public function handleReceiptOption(Request $request)
    {
        $receiptOption = $request->input('receiptOption');

        $transactionId = session('transaction_id');

        if ($receiptOption === 'print') {
            return redirect()->route('receipt.generatePdf', ['transactionId' => $transactionId]);
        }

        return redirect()->route('cart.view')->with('success', 'Gefeliciteerd met je bestelling');
    }

    public function getCartCount()
    {
        $cart = $this->cart->getCart();
        return response()->json(['count' => count($cart)]);
    }
}
