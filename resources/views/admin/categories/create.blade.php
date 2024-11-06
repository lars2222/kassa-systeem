@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>category toevoegen</h2>
    <form action="{{ route('categories.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">naam</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">beschrijving</label>
            <input type="text" class="form-control" name="description" id="description" required>
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection