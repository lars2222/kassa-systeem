<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center mt-5">
        <div class="alert alert-success">
            <h1>Bedankt voor je bestelling!</h1>
            <p>Je betaling is succesvol verwerkt.</p>
        </div>
        <div class="mt-4">
            <h3>Wisselgeld Teruggave</h3>
            <p>Je krijgt <strong>{{ $change }} €</strong> terug.</p>
        </div>
        <div class="mt-4">
            <h3>Kies een optie voor de bon</h3>
            <form id="receipt-form" action="{{ route('cart.receiptOption') }}" method="POST">
                @csrf
                <input type="hidden" name="transactionId" value="{{ session('transaction_id') }}">
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="receiptOption" id="printReceipt" value="print">
                    <label class="form-check-label" for="printReceipt">
                        Bon afdrukken
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="receiptOption" id="noReceipt" value="none" checked>
                    <label class="form-check-label" for="noReceipt">
                        Geen bon
                    </label>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Bevestig keuze</button>
            </form>
        </div>
        <div class="mt-4">
            <p>Je wordt binnen <strong id="countdown">10</strong> seconden doorgestuurd naar de winkelwagen.</p>
        </div>
    </div>
</body>
</html>

<script>
    let countdownElement = document.getElementById('countdown');
    let countdown = 10; 

    let interval = setInterval(function() {
        countdown--;
        countdownElement.textContent = countdown;

        if (countdown <= 0) {
            clearInterval(interval);
            window.location.href = "{{ route('cart.view') }}";
        }
    }, 1000);
</script>
