<form action="{{ route('products.search') }}" method="GET" class="d-flex justify-content-center">
    <div class="input-group" style="max-width: 600px; margin: 0 auto;">
        <input type="text" name="search" class="form-control" placeholder="Zoek een product..." aria-label="Zoek een product..." value="{{ request('search') }}">
    </div>
</form>