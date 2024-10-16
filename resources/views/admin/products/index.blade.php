@extends('admin.layouts.app')

@section('content')
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">Barcode</th>
                <th scope="col">Naam</th>
                <th scope="col">Prijs</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
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
                            <i class="fa-solid fa-pen-to-square"></i>
                            product bewerken
                        </a>
                        <form action="{{route('products.destroy',$product)}}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{$product->id}}">
                            <button type="submit" class="btn btn-sm btn-danger me-2">
                                verwijder
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection