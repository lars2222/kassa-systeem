<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function generatePdf($transactionId)
    { 
        $transaction = Transaction::with(['products.taxRate', 'products.discounts'])->findOrFail($transactionId);

        $data = [
            'title' => 'Kassabon',
            'date' => date('d/m/y'),
            'transaction' => $transaction,
            'products' => $this->prepareProductsData($transaction->products),
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data);
        return $pdf->download('invoice.pdf');
    }

    private function prepareProductsData($products)
    {
        return $products->map(function ($product) {
            $originalPriceInclTax = $product->getOriginalPriceIncludingTax();
            $discountedPriceInclTax = $product->getDiscountedPriceIncludingTax();

            return [
                'name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'price_excl_vat' => $product->pivot->price_at_time,
                'price_incl_vat' => $originalPriceInclTax,
                'discounted_price_incl_vat' => $discountedPriceInclTax,
                'total_excl_vat' => $product->pivot->price_at_time * $product->pivot->quantity,
                'total_incl_vat' => $discountedPriceInclTax * $product->pivot->quantity,
            ];
        });
    }
}
