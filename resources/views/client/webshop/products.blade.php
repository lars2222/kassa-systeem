@extends('client.shopping-cart.layouts.app')

@section('content')
<div class="container text-center">
    <div class="my-4">
        @if(isset($category))
            <h1>Producten in categorie: {{ $category->name }}</h1>
        @else
            <h1>Producten</h1>
        @endif
    </div>

    @include('client.partials.search-bar') <!-- Zoekbalk -->

    <div class="results-container mt-4">
        <div class="container">
            <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @foreach ($categories as $categoryItem)
                    <div class="col-md-2 mb-4 d-flex justify-content-center">
                        <a href="#" class="category-card" onclick="loadProducts({{ $categoryItem->id }}); return false;">
                            <div class="card text-center" style="width: 100%; padding: 20px;">
                                <h2>{{ $categoryItem->name }}</h2>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="products-list mt-4">
        @include('client.partials.product-list', ['products' => $products]) <!-- Productenlijst -->
    </div>
</div>
@endsection

@include('client.webshop.products-js')
