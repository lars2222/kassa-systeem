@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>taxrate toevoegen</h2>
    <form action="{{ route('taxRates.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="btw_type">BTW Type</label>
            <select class="form-control" name="type" id="type" required>
                <option value="high">High</option>
                <option value="low">Low</option>
            </select>
            @error('type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> 

        <div class="form-group">
            <label for="percentage">Percentage</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">%</span>
                </div>
                <input type="number" class="form-control" name="percentage" id="percentage" required>
            </div>
            @error('percentage')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="start_date">Startdatum</label>
            <input type="date" class="form-control" name="start_date" id="start_date" required>
            @error('start_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection