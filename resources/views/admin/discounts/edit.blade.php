@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>korting bewerken</h2>
    <form action="{{ route('discounts.update', $discount->id) }}" method="post">
        @csrf
        @method('PUT') 
        
        <div class="form-group">
            <label for="description">naam</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $discount->name) }}" required>
        </div>

        <div class="form-group">
            <label for="value">waarde</label>
            <input type="text" class="form-control" name="value" id="value" value="{{ old('value', $discount->value) }}" required>
        </div>

        <div class="form-group">
            <label for="name">start datum</label>
            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date', $discount->start_date) }}" required>
        </div>

        <div class="form-group">
            <label for="name">eind datum</label>
            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date', $discount->end_date) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>

@endsection