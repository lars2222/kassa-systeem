@extends('admin.layouts.app')

@section('content')
<div class="container mt-3">

    @extends('admin.products.nav')

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Barcode</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Prijs</th>
                    <th scope="col">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2, ',', '.') }} €</td> 
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-dark me-2">
                                <i class="fa-solid fa-pen-to-square"></i> Bewerken
                            </a>
                            <form action="{{route('products.destroy', $product)}}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger me-2">
                                    Verwijderen
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
