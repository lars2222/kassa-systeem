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

    public function getTotal()
    {
        return $this->calculateTotal();
    }
}
