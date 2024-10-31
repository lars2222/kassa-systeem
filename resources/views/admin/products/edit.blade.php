@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Product bewerken</h2>
    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        
        <div class="form-group">
            <label for="barcode">Barcode</label>
            <input type="number" class="form-control" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}" required>
        </div>

        <div class="form-group">
            <label for="name">Naam</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label for="price">Prijs</label>
            <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="form-group">
            <label for="price">beschrijving</label>
            <input type="text" class="form-control" name="description" id="description" value="{{ old('description', $product->description) }}" required>
        </div>

        <div class="form-group">
            <label for="image">Afbeelding</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*"> 
        </div>

        <div class="form-group">
            <label for="tax_rate_id">BTW Type</label>
            <select class="form-control" name="tax_rate_id" id="tax_rate_id" required>
                <option value="">Selecteer een btw type</option>
                @foreach($taxRates as $taxRate)
                    <option value="{{ $taxRate->id }}" {{ old('tax_rate_id', $product->tax_rate_id) == $taxRate->id ? 'selected' : '' }}>
                        {{ $taxRate->type }}
                    </option>
                @endforeach
            </select>
        </div>  
        
        <div class="form-group">
            <label for="category">Categorie</label>
            <select class="form-control" name="category_id" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>
@endsection
