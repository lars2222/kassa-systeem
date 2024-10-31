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
        @endforeach
    </div>
@endif
