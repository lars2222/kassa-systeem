<!-- resources/views/pdf/invoice.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Datum: {{ $date }}</p>
    
    <h3>Transactiegegevens</h3>
    <p>Transactie ID: {{ $transaction->id }}</p>
    <p>Totaal: €{{ number_format($transaction->total, 2, ',', '.') }}</p>

    <h3>Producten</h3>
    <table>
        <thead>
            <tr>
                <th>Productnaam</th>
                <th>Aantal</th>
                <th>Prijs per stuk</th>
                <th>Totaal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>€{{ number_format($product->pivot->price_at_time, 2, ',', '.') }}</td>
                <td>€{{ number_format($product->pivot->total, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
