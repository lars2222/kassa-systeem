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
                            @include('client.partials.product-info')
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
