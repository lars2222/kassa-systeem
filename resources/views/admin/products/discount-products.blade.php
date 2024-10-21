@extends('admin.layouts.app')

@section('content')
<div class="container mt-3">
            
    @extends('admin.products.nav')

    <h2>Kortingen aan producten koppelen</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Product Naam</th>
                    <th scope="col">Huidige Kortingen</th>
                    <th scope="col">Korting toevoegen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            @if ($product->discounts->isNotEmpty())
                                <ul>
                                    @foreach ($product->discounts as $discount)
                                        <li>
                                            {{ $discount->name }} (%{{ $discount->value }})
                                            <form action="{{ route('products.removeDiscount', [$product->id, $discount->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Verwijder</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                Geen kortingen
                            @endif
                        </td>
                        <td>
                            <div class="mt-2">
                                <form action="{{ route('products.addDiscount', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <select name="discount_id" class="form-control" required>
                                            <option value="">Selecteer korting</option>
                                            @foreach ($discounts as $discount)
                                                <option value="{{ $discount->id }}">{{ $discount->name }} (%{{ $discount->value }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm mt-2">Voeg korting toe</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection