@extends('admin.layouts.app')

@section('content')
<div class="container dashboard">
    <h2 class="my-4">Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-4 d-flex">
            <div class="card border-primary flex-fill">
                <div class="card-body">
                    <h5 class="card-title">Verkoop Statistieken</h5>
                    <p class="card-text"><strong>Totaal Verkoop:</strong> €{{ number_format($totalSales, 2, ',', '.') }}</p>
                    <p class="card-text"><strong>Aantal Bestellingen:</strong> {{ $totalOrders }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex">
            <div class="card border-info flex-fill">
                <div class="card-body">
                    <h5 class="card-title">Top Verkochte Producten</h5>
                    <ul class="list-group">
                        @foreach($topSellingProducts as $product)
                            <li class="list-group-item">{{ $product->name }} - {{ $product->sold_quantity }} stuks verkocht</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex">
            <div class="card border-success flex-fill">
                <div class="card-body">
                    <h5 class="card-title">Totale Omzet per Product</h5>
                    <ul class="list-group">
                        @foreach($totalSalesPerProduct as $sale)
                            <li class="list-group-item">Product ID: {{ $sale->product_id }} - Omzet: €{{ number_format($sale->total_sales, 2, ',', '.') }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 d-flex">
            <div class="card border-warning flex-fill">
                <div class="card-body">
                    <h5 class="card-title">Verkochte Producten per Maand en Jaar</h5>
                    <ul class="list-group">
                        @foreach($monthlyProductSales as $sale)
                            <li class="list-group-item">Jaar: {{ $sale->year }}, Maand: {{ $sale->month }}, 
                                Product ID: {{ $sale->product_id }}, 
                                Aantal verkocht: {{ $sale->total_sold }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 d-flex">
            <div class="card border-danger flex-fill">
                <div class="card-body">
                    <h5 class="card-title">Bestellingen per Maand en Jaar</h5>
                    <ul class="list-group">
                        @foreach($monthlyOrderCount as $order)
                            <li class="list-group-item">Jaar: {{ $order->year }}, Maand: {{ $order->month }}, 
                                Aantal Bestellingen: {{ $order->order_count }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
