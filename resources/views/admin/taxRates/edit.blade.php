@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>BTW bewerken</h2>
    <form action="{{ route('taxRate.update', $taxRate->id) }}" method="post">
        @csrf
        @method('PUT') 
        
        <div class="form-group">
            <label for="btw_type">BTW Type</label>
            <select class="form-control" name="type" id="type" value="{{ old('btw_type', $taxRate->btw_type) }}" required>
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
                <input type="number" class="form-control" name="percentage" id="percentage" value="{{ old('percentage', $taxRate->percentage) }}" required>
            </div>
            @error('percentage')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="start_date">Startdatum</label>
            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date', $taxRate->start_date) }}" required>
            @error('start_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection