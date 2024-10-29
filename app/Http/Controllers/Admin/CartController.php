<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Checkout\CheckoutRequest;
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

    public function checkout(CheckoutRequest $request)
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

    // Create transaction
    $transaction = Transaction::create([
        'user_id' => 1,
        'subtotal' => $totalAmount,
        'total' => $totalAmount, 
        'tax' => 0, 
    ]);

    // Create payment record
    Payment::create([
        'transaction_id' => $transaction->id,
        'amount' => $totalAmount,
        'method' => $request->payment_method,
        'cash_received' => $request->payment_method === 'cash' ? $cashReceived : null,
        'change_given' => $change,
    ]);

    // Process each item in the cart
    foreach ($cart as $item) {
        if (isset($item['product'])) { 
            $productId = $item['product']->id; 
            $quantity = $item['quantity']; // Get the quantity of the product in the cart

            // Update the transaction product association
            $transaction->products()->attach($productId, [
                'quantity' => $quantity, 
                'price_at_time' => $item['product']->price, 
                'total' => $quantity * $item['product']->price, 
                'discount_applied' => $item['discount'] ?? 0, 
            ]);
        }    
    }

    // Update inventory for the products sold
    $this->updateInventory($cart);

    // Clear the cart after successful transaction
    $this->cart->emptyCart();

    session(['transaction_id' => $transaction->id]);

    return redirect()->route('cart.reciept')->with([
        'success' => 'Bedankt voor je bestelling! Je kassabon is beschikbaar als PDF.',
        'cart' => $cart,
        'change' => number_format($change, 2, ',', '.'),
    ]);
}

    protected function updateInventory($cart)
    {
        foreach ($cart as $item) {
            if (isset($item['product'])) { 
                $productId = $item['product']->id; 
                $quantity = $item['quantity']; // Get the quantity of the product in the cart

                // Update product stock
                $product = Product::find($productId);
                if ($product && $product->inventory) {
                    $product->inventory->quantity -= $quantity; // Deduct the purchased quantity from stock
                    $product->inventory->save(); // Save the updated stock
                }
            }
        }
    }


    public function chooseRecieptOption()
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

        return redirect()->route('welcome')->with('success', 'bedankt voor je bestelling');
    }

}
