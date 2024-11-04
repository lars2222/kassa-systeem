@extends('admin.layouts.app')

@section('title', 'Kortingen')

@section('create-btn', route('categories.create'))

@section('content')
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">naam</th>
                <th scope="col">waarde</th>
                <th scope="col">start datum</th>
                <th scope="col">eind datum</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($discounts as $discount)
                <tr>
                    <td>{{ $discount->name }}</td>
                    <td>%{{ number_format($discount->value, 0) }}</td>
                    <td>{{ $discount->start_date }} </td> 
                    <td>{{ $discount->end_date }}</td>
                    <td>
                        <a href="{{ route('discounts.edit', $discount) }}" class="btn btn-sm btn-dark me-2">
                            <i class="fa-solid fa-pen-to-square"></i>
                            kortings bewerken
                        </a>
                        <form action="{{route('discounts.destroy',$discount)}}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{$discount->id}}">
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