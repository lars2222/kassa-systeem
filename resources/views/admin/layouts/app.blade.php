<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('admin.layouts.top')
    <div class="container">
        <div class="row">
            @include('admin.layouts.sidebar') 
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                @yield('content') 
            </main>
        </div>
    </div>
    @include('admin.layouts.footer') 
</body>
</html>