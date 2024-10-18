@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>korting toevoegen</h2>
    <form action="{{ route('discounts.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="barcode">naam</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="value">Waarde</label>
            <div class="input-group">
                <span class="input-group-text">%</span>
                <input type="number" class="form-control" name="value" id="value" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description">start datum</label>
            <input type="date" class="form-control" name="start_date" id="start_date" required>
        </div>

        <div class="form-group">
            <label for="description">eind datum</label>
            <input type="date" class="form-control" name="end_date" id="end_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection