@extends('admin.layouts.app')

@section('title', 'Categorieën') 

@section('create-btn', route('categories.create'))

@section('content')
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Acties</th>  
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-dark me-2">
                            <i class="fa-solid fa-pen-to-square"></i> Bewerken
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger me-2">Verwijder</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
