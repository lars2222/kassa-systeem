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
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>

@endsection