<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container">
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>


