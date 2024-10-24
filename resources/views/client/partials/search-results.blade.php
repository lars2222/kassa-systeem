<div class="results-container mt-4">
    @if($products->isEmpty())
        <div class="alert alert-warning" role="alert">
            Geen producten gevonden.
        </div>
    @else
        @php $counter = 0; @endphp
        <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
            @foreach ($products as $product)
                @if ($counter > 0 && $counter % 5 === 0) 
                    </div>
                    <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @endif

                <div class="col-md-3 mb-4 d-flex justify-content-center">
                    <div class="card" style="width: 100%;">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Prijs: {{ number_format($product->price, 2, ',', '.') }} €</p>

                            <!-- Button to open product info -->
                            <button class="open-button" onclick="toggleProductInfo(this);">product info</button>

                            <!-- Product information (initially hidden) -->
                            <div class="product-info" style="display: none;">
                                <ul id="product-details">
                                    <li>Product Name: {{ $product->name }}</li>
                                    <li>Price: {{ number_format($product->price, 2, ',', '.') }} €</li>
                                    <li>Description: {{ $product->description }}</li>
                                </ul>
                                <button type="button" class="btn cancel" onclick="toggleProductInfo(this)">Close</button>
                            </div>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
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

@include('client.partials.js')
