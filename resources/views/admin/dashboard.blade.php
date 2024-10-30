@extends('admin.layouts.app')

@section('content')
<div class="dashboard">
    <h2>Dashboard</h2>

    <div class="stats">
        <p><strong>Totaal Verkoop:</strong> €{{ number_format($totalSales, 2, ',', '.') }}</p>
        <p><strong>Aantal Bestellingen:</strong> {{ $totalOrders }}</p>
    </div>

    <div class="top-selling-products">
        <h3>Top Verkochte Producten</h3>
        <ul>
            @foreach($topSellingProducts as $product)
                <li>{{ $product->name }} - {{ $product->sold_quantity }} stuks verkocht</li>
            @endforeach
        </ul>
    </div>

    <div class="total-sales-per-product">
        <h3>Totale Omzet per Product</h3>
        <ul>
            @foreach($totalSalesPerProduct as $sale)
                <li>Product ID: {{ $sale->product_id }} - Omzet: €{{ number_format($sale->total_sales, 2, ',', '.') }}</li>
            @endforeach
        </ul>
    </div>

    <div class="monthly-product-sales">
        <h3>Verkochte Producten per Maand en Jaar</h3>
        <ul>
            @foreach($monthlyProductSales as $sale)
                <li>Jaar: {{ $sale->year }}, Maand: {{ $sale->month }}, 
                    Product ID: {{ $sale->product_id }}, 
                    Aantal verkocht: {{ $sale->total_sold }}
                </li>
            @endforeach
        </ul>
    </div>
    
    <div class="monthly-order-count">
        <h3>Bestellingen per Maand en Jaar</h3>
        <ul>
            @foreach($monthlyOrderCount as $order)
                <li>Jaar: {{ $order->year }}, Maand: {{ $order->month }}, 
                    Aantal Bestellingen: {{ $order->order_count }}
                </li>
            @endforeach
        </ul>
    </div>
 
</div>

@endsection