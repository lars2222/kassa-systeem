@extends('client.shopping-cart.layouts.app')

@section('content')
<div class="container text-center">

    <div id="cart-count-container" class="my-4">
        <h2>
            Winkelwagen: 
            <a href="{{ route('cart.view') }}" id="cart-count" class="btn btn-primary" style="text-decoration: none; color: white;">
                <span id="cart-count-value">0</span> producten
            </a>
        </h2> 
    </div>
    
    <div class="my-4">
        @if(isset($category))
            <h1>Producten in categorie: {{ $category->name }}</h1>
        @else
            <h1>Producten</h1>
        @endif
    </div>

    @include('client.partials.search-bar') 

    <div class="results-container mt-4">
        <div class="container">
            <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @foreach ($categories as $category)
                    <div class="col-md-2 mb-4 d-flex justify-content-center">
                        <a href="#" class="category-card" onclick="loadProducts({{ $category->id }}); return false;">
                            <div class="card text-center" style="width: 100%; padding: 20px;">
                                <h2>{{ $category->name }}</h2>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="products-list mt-4">
        @include('client.partials.product-list', ['products' => $products]) 
    </div>
</div>
@endsection  

@include('client.webshop.products-js') 
