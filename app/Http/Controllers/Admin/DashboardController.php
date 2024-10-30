<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Transaction::getTotalSales();
        $totalOrders = Transaction::getTotalOrders();
        $monthlySales = Transaction::getSalesByMonth();

        $topSellingProducts = Product::getTopSellingProducts();
        $totalSalesPerProduct = Product::getTotalSalesPerProduct();
        $monthlyProductSales = Transaction::getMonthlyProductSales();
        $monthlyOrderCount = Transaction::getMonthlyOrderCount();

        return view('admin.dashboard', compact(
            'totalSales', 'totalOrders', 'monthlySales',
            'topSellingProducts', 'totalSalesPerProduct', 
            'monthlyProductSales', 'monthlyOrderCount'
        ));
    }
}
