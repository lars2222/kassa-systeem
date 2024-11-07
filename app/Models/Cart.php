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
            $total += $item['product']->getDiscountedPriceIncludingTax() * $item['quantity'];
        }

        return $total;
    }

    public function calculateTotalWithoutDiscount()
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['product']->getOriginalPriceIncludingTax() * $item['quantity'];
        }

        return $total;
    }

    public function calculateTotalDiscount()
    {
        $cart = $this->getCart();
        $totalDiscount = 0;

        foreach ($cart as $item) {
            $originalPrice = $item['product']->getOriginalPriceIncludingTax();
            $discountedPrice = $item['product']->getDiscountedPriceIncludingTax();
            $totalDiscount += ($originalPrice - $discountedPrice) * $item['quantity'];
        }

        return $totalDiscount;
    }

    public function getTotal()
    {
        return $this->calculateTotal();
    }
}
