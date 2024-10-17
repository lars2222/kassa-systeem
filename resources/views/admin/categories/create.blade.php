@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>category toevoegen</h2>
    <form action="{{ route('categories.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="barcode">naam</label>
            <input type="text" class="form-control" name="name" id="barcode" required>
        </div>

        <div class="form-group">
            <label for="description">beschrijving</label>
            <input type="text" class="form-control" name="description" id="description" required>
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection