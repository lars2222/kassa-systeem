@extends('admin.layouts.app')

@section('content')
<div class="container mt-3">
    @extends('admin.products.nav')

    <h2>Product Voorraad</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Product Naam</th>
                    <th scope="col">Huidige Voorraad</th>
                    <th scope="col">Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->inventory->quantity ?? 0 }}</td>
                        <td>
                            <form action="{{ route('products.updateStock', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group d-flex align-items-center">
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="setOperation(this, 'subtract', {{ $product->inventory->quantity ?? 0 }})">-</button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="setOperation(this, 'add', {{ $product->inventory->quantity ?? 0 }})">+</button>
                                    <input type="number" name="quantity" class="form-control mx-2" value="0" min="0" required style="width: 80px; text-align: center;">
                                    <input type="hidden" name="operation" id="operation" value="">
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm mt-2">Bijwerken</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function setOperation(button, operation, currentStock) {
        const inputField = button.parentElement.querySelector('input[name="quantity"]');
        const operationInput = button.parentElement.querySelector('input[name="operation"]');
        
        resetButtonStyles(button.parentElement);
        inputField.value = 0; 

        if (operation === 'add') {
            button.parentElement.querySelector('button[onclick*="add"]').classList.add('btn-success'); 
            operationInput.value = 'add'; 
            inputField.placeholder = 'Aantal toevoegen'; 
        } else {
            button.parentElement.querySelector('button[onclick*="subtract"]').classList.add('btn-danger'); 
            operationInput.value = 'subtract'; 
            inputField.placeholder = 'Aantal verminderen'; 
        }
    }

    function resetButtonStyles(container) {
        const buttons = container.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.classList.remove('btn-success', 'btn-danger'); 
            btn.classList.add('btn-secondary'); 
        });
    }
</script>
@endsection
