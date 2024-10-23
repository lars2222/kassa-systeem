<div class="container text-center">
    <div class="my-4">
        @if (request('search'))
            <h1>Zoekresultaten voor: "{{ request('search') }}"</h1>
        @else
            @if(isset($category))
                <h1>Producten in categorie: {{ $category->name }}</h1>
            @else
                <h1>Producten</h1>
            @endif
        @endif
    </div>

    @include('client.partials.search-bar')

    @include('client.partials.search-results')
</div>

@include('client.webshop.js')
