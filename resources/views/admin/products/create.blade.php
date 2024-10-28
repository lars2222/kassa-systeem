@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Product toevoegen</h2>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
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
            <label for="price">beschrijving</label>
            <input type="text" class="form-control" name="description" id="description" required>
        </div>

        <div class="form-group">
            <label for="image">Afbeelding</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="category">Categorieën</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Selecteer een categorie</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

       <div class="form-group">
            <label for="btw_type">BTW Type</label>
            <select class="form-control" name="btw_type" id="btw_type" required>
                <option value="">selecteer een btw type</option>
                <option value="high">High</option>
                <option value="low">Low</option>
            </select>
        </div> 

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection