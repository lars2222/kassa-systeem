@extends('client.shopping-cart.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <h2>Zoek</h2>
        <ul class="list-group">
            @include('client.partials.search-bar')
            @foreach ($categories as $category)
                <li class="list-group-item">
                    <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                </li>
            @endforeach                
        </ul>
    </div>

    <div class="col-md-9">
        <h1 class="my-4">Winkelwagentje</h1>
        <span id="cart-count-value">{{ count($cart) }}</span> producten

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (empty($cart))
            <div class="alert alert-warning" role="alert">
                Je winkelwagentje is leeg.
            </div>
        @else
            <form action="{{ route('cart.empty') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger mb-3">Winkelwagen legen</button>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Aantal</th>
                        <th scope="col">Subtotaal (incl. korting en btw)</th>
                        <th scope="col">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        @php
                            $originalPrice = $item['product']->getOriginalPriceIncludingTax();
                            $discountedPrice = $item['product']->getDiscountedPriceIncludingTax();
                        @endphp
                        <tr data-product-id="{{ $item['product']->id }}">
                            <td>{{ $item['product']->name }}</td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary decrease-quantity">-</button>
                                    </div>
                                    <input type="number" class="form-control text-center quantity" value="{{ $item['quantity'] }}" min="1" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary increase-quantity">+</button>
                                    </div>
                                </div>
                            </td>
                            <td class="subtotal">
                                @if ($discountedPrice < $originalPrice)
                                    <span style="text-decoration: line-through;">{{ number_format($originalPrice * $item['quantity'], 2, ',', '.') }} €</span>
                                @endif
                                {{ number_format($discountedPrice * $item['quantity'], 2, ',', '.') }} €
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-product">Verwijderen</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Totaal: <span class="total">{{ number_format($total, 2, ',', '.') }} €</span></h3>
            <h4>Korting totaal: <span class="total-discount">{{ number_format($totalDiscount, 2, ',', '.') }} €</span></h4>

            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="payment_method">Kies een betaalmethode:</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="" disabled selected>Kies een betaalmethode</option>
                        <option value="cash">Contant</option>
                        <option value="card">Pin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Afrekenen</button>
            </form>
        @endif
    </div>
</div>
@endsection
