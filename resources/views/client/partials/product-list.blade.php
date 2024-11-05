@if ($products->isEmpty())
    <div class="alert alert-warning" role="alert">
        Geen producten gevonden.
    </div>
@else
    <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4 d-flex justify-content-center">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        
                        @php
                            $originalPrice = $product->price * (1 + ($product->taxRate->percentage ?? 0) / 100);
                            $discountedPrice = $product->price_including_tax;
                            $hasDiscount = $product->discounts()
                                ->whereDate('start_date', '<=', Carbon\Carbon::today())
                                ->where(function ($query) {
                                    $query->whereNull('end_date')
                                          ->orWhere('end_date', '>=', Carbon\Carbon::today());
                                })
                                ->exists();
                        @endphp

                        @if ($hasDiscount)
                            <p class="card-text">Originele prijs (incl. btw): <span style="text-decoration: line-through;">{{ number_format($originalPrice, 2, ',', '.') }} €</span></p>
                            <p class="card-text">Prijs (incl. korting en btw): {{ number_format($discountedPrice, 2, ',', '.') }} €</p>
                        @else
                            <p class="card-text">Prijs (incl. btw): {{ number_format($discountedPrice, 2, ',', '.') }} €</p>
                        @endif

                        <button class="open-button" onclick="toggleProductInfo(this);">Product Info</button>
                        <div class="product-info" style="display: none;">
                            <ul id="product-details">
                                <li>Productnaam: {{ $product->name }}</li>
                                <li>Prijs (incl. korting en btw): {{ number_format($discountedPrice, 2, ',', '.') }} €</li>
                            </ul>
                            <button type="button" class="btn cancel" onclick="toggleProductInfo(this)">Sluiten</button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form" id="add-to-cart-form-{{ $product->id }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-primary w-100 add-to-cart-button">Toevoegen aan winkelwagentje</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
