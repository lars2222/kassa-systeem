<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten Zoeken</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/js/app.js'])
</head>
<body class="bg-primary">
    <div class="container-fluid vh-100 d-flex p-4">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-light rounded p-3">
            <h2 class="bg-secondary text-white text-center rounded py-2">producten zoeken</h2>
            <div class="mt-4">
                <p class="fw-bold mb-1">🍇 fruit</p>
                <div class="text-muted">appels, banaan</div>
            </div>
            <hr>
            <div class="mt-4">
                <p class="fw-bold mb-1">🍏 groente</p>
                <div class="text-muted">kool, sla, paprika</div>
            </div>
            <hr>
            <div class="mt-4">
                <p class="fw-bold mb-1">👨‍🍳 bakkerij</p>
                <div class="text-muted">broodje, zoet</div>
            </div>
            <hr>
            <div class="mt-4">
                <p class="fw-bold mb-1">☂️ overig</p>
                <div class="text-muted">tassen, loten</div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-3 d-flex flex-column justify-content-between bg-white rounded">
            <div class="p-4 text-center flex-grow-1"></div>
            <div class="d-flex justify-content-between align-items-center p-3">
                <button class="btn btn-primary">afrekenen</button>
                <span class="fw-bold">0.00</span>
                <span class="fw-bold">0.00</span>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
