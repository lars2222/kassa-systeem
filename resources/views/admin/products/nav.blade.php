<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <a class="navbar-brand" href="{{ route('products.index') }}">Producten</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.discount-products') }}">Kortingen aan producten koppelen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.stock') }}">Product Voorraad</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.create') }}">Maak product aan</a>
            </li>
        </ul>
    </div>
</nav>