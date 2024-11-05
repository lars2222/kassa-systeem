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
                                {{ number_format($item['product']->getDiscountedPriceIncludingTax() * $item['quantity'], 2, ',', '.') }} €
                            </td>
                            <td class="original-price" style="text-decoration: line-through; color: grey;">
                                {{ number_format($item['product']->getOriginalPriceIncludingTax() * $item['quantity'], 2, ',', '.') }} €
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-product">Verwijderen</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>                
            </table>
    
            <h3>Totaal: <span class="total">{{ number_format($total, 2, ',', '.') }} €</span></h3>
            @if($totalDiscount > 0)
                <h4>Korting: <span class="discount">{{ number_format($totalDiscount, 2, ',', '.') }} €</span></h4>
                <h4>Eindtotaal: <span class="final-total">{{ number_format($total - $totalDiscount, 2, ',', '.') }} €</span></h4>
            @endif
            
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

                <div class="form-group bank-input" style="display: none;">
                    <label for="bank">Kies uw bank:</label>
                    <select name="bank" id="bank" class="form-control">
                        <option value="" disabled selected>Kies uw bank</option>
                        <option value="rabobank">Rabobank</option>
                        <option value="ing">ING</option>
                        <option value="abnamro">ABN AMRO</option>
                        <option value="sns">SNS Bank</option>
                    </select>
                </div>

                <div class="form-group pin-input" style="display: none">
                    <label for="pin_code">Voer uw pincode in</label>
                    <input type="password" name="pin_code" class="form-control" minlength="4" maxlength="4" pattern="\d{4}" placeholder="****">
                </div>

                <div class="form-group cash-input" style="display:none;">
                    <label for="cash_received">Ontvangen bedrag:</label>
                    <input type="number" name="cash_received" id="cash_received" class="form-control" step="0.01" min="0">
                </div>
                
                <button type="submit" class="btn btn-success">Afrekenen</button>
            </form>
        @endif
    </div>
</div>
@endsection

@include('client.shopping-cart.cart-js')
