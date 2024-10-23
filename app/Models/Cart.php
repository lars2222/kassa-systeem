<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class Cart
{
    public function addProduct($productId, $quantity)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $product = Product::find($productId);
            if ($product) {
                $cart[$productId] = [
                    'quantity' => $quantity,
                    'product' => $product,
                ];
            }
        }

        Session::put('cart', $cart);
    }

    public function removeProduct($productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }
    }

    public function emptyCart()
    {
        Session::forget('cart');

        return redirect()->route('cart.view')->with('success', 'je winkelwagen is geleegd');
    }

    public function getCart()
    {
        return Session::get('cart', []);
    }

    public function calculateTotal()
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['product']->price * $item['quantity'];
        }

        return $total;
    }
}
