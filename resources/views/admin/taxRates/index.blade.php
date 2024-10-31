@extends('admin.layouts.app')

@section('content')
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">type</th>
                <th scope="col">percentage</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($taxRates as $taxRate)
                <tr>
                    <td>{{ $taxRate->type }}</td>
                    <td>%{{ $taxRate->percentage }}</td>
                    <td>
                        <a href="{{ route('taxRates.edit', $taxRate) }}" class="btn btn-sm btn-dark me-2">
                            <i class="fa-solid fa-pen-to-square"></i>
                            product bewerken
                        </a>
                        <form action="{{route('taxRates.destroy',$taxRate)}}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{$taxRate->id}}">
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