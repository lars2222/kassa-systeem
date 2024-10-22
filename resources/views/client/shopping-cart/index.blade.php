@extends('client.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h4>Categorieën</h4>
            <ul class="list-group">
                @foreach ($categories as $category)
                    <li class="list-group-item">
                        <a href="{{ route('category.show', $category->id) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div class="col-md-9">
            <h1 class="my-4">Winkelwagentje</h1>

            @if (empty($cart))
                <div class="alert alert-warning" role="alert">
                    Je winkelwagentje is leeg.
                </div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Aantal</th>
                            <th scope="col">Subtotaal</th>
                            <th scope="col">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item['product']->name }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['product']->price * $item['quantity'], 2, ',', '.') }} €</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3>Totaal: {{ number_format($total, 2, ',', '.') }} €</h3>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Afrekenen</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
