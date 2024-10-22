<aside class="col-md-3 col-lg-2 bg-light vh-100 sidebar">
    <h2 class="mt-4">Menu</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('products.index') }}">producten</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index')}}">categorieen</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('discounts.index')}}">kortingen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">Uitloggen</a>
        </li>
    </ul>
</aside>