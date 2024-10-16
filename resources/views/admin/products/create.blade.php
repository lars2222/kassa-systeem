@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Product toevoegen</h2>
    <form action="{{ route('products.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="barcode">Barcode</label>
            <input type="number" class="form-control" name="barcode" id="barcode" required>
        </div>

        <div class="form-group">
            <label for="name">Naam</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="price">Prijs</label>
            <input type="text" class="form-control" name="price" id="price" required>
        </div>

       <div class="form-group">
            <label for="btw_type">BTW Type</label>
            <select class="form-control" name="btw_type" id="btw_type" required>
                <option value="high">High</option>
                <option value="low">Low</option>
            </select>
        </div> 

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection