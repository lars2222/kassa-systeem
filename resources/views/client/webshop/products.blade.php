@extends('client.shopping-cart.layouts.app')

<div class="container text-center">
    <div class="my-4">
        @if (request('search'))
            <h1>Zoekresultaten voor: "{{ request('search') }}"</h1>
        @else
            @if(isset($category))
                <h1>Producten in categorie: {{ $category->name }}</h1>
            @else
                <h1>Producten</h1>
            @endif
        @endif
    </div>

    @include('client.partials.search-bar')

    <div class="results-container mt-4">
        <div class="container">
            <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @php $categoryCounter = 0; @endphp
                @foreach ($categories as $category)
                    @if ($categoryCounter >= 6)
                        @break
                    @endif
    
                    <div class="col-md-2 mb-4 d-flex justify-content-center">
                        <a href="{{ route('category.show', $category->id) }}" class="category-card">
                            <div class="card text-center" style="width: 100%; padding: 20px;">
                                <h2>{{ $category->name }}</h2>
                            </div>
                        </a>
                    </div>
    
                    @php $categoryCounter++; @endphp
                @endforeach
            </div>
        </div>
    
        @if ($products->isEmpty())
            <div class="alert alert-warning" role="alert">
                Geen producten gevonden.
            </div>
        @else
            @php $counter = 0; @endphp
            <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @foreach ($products as $product)
                    @if ($counter > 0 && $counter % 4 === 0) 
                        </div>
                        <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                    @endif
    
                    <div class="col-md-3 mb-4 d-flex justify-content-center">
                        <div class="card" style="width: 100%;">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">Prijs: {{ number_format($product->price, 2, ',', '.') }} €</p>
    
                                <button class="open-button" onclick="toggleProductInfo(this);">Product Info</button>
    
                                <div class="product-info" style="display: none;">
                                    <ul id="product-details">
                                        <li>Productnaam: {{ $product->name }}</li>
                                        <li>Prijs: {{ number_format($product->price, 2, ',', '.') }} €</li>
                                        <li>Beschrijving: {{ $product->description }}</li>
                                    </ul>
                                    <button type="button" class="btn cancel" onclick="toggleProductInfo(this)">Sluiten</button>
                                </div>
                            </div>
                            <div class="card-footer">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Toevoegen aan winkelwagentje</button>
                                </form>
                            </div>
                        </div>
                    </div>
    
                    @php $counter++; @endphp
                @endforeach
            </div>
        @endif
    </div>
</div>

@include('client.webshop.products-js')
