<aside class="col-md-3 col-lg-2 bg-light vh-100 sidebar border-end p-3">
    <h2 class="text-center mb-4">Menu</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">
                <i class="fas fa-box"></i> Producten
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class="fas fa-tags"></i> Categorieën
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('discounts.index') }}">
                <i class="fas fa-percent"></i> Kortingen
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-danger" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i> Uitloggen
            </a>
        </li>
    </ul>
</aside>
