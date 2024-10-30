<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function generatePdf($transactionId)
    { 
        $transaction = Transaction::with('products')->findOrFail($transactionId);
        $data =   [
            'title' => 'kassabon',
            'date' => date('d/m/y'),
            'transaction' =>$transaction,
            'products' => $transaction->products,
        ];
        $pdf = Pdf::loadView('pdf.invoice', $data);
        return $pdf->download('invoice.pdf');
    }
}
