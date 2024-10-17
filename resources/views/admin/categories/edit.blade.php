@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Product bewerken</h2>
    <form action="{{ route('categories.update', $category->id) }}" method="post">
        @csrf
        @method('PUT') 
        
        <div class="form-group">
            <label for="description">naam</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="form-group">
            <label for="name">description</label>
            <input type="text" class="form-control" name="description" id="description" value="{{ old('description', $category->description) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>

@endsection