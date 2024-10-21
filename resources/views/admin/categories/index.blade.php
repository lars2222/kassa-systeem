@extends('admin.layouts.app')

@section('content')
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">naam</th>
                <th scope="col">beschrijving</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-dark me-2">
                            <i class="fa-solid fa-pen-to-square"></i>
                            category bewerken
                        </a>
                        <form action="{{route('categories.destroy',$category)}}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{$category->id}}">
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