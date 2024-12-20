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
    <p>Totaal (incl. btw): €{{ number_format($transaction->total, 2, ',', '.') }}</p>

    <h3>Producten</h3>
    <table>
        <thead>
            <tr>
                <th>Productnaam</th>
                <th>Aantal</th>
                <th>Prijs per stuk (excl. btw)</th>
                <th>Prijs per stuk (incl. btw)</th>
                <th>Prijs na korting (incl. btw)</th>
                <th>Totaal (excl. btw)</th>
                <th>Totaal (incl. btw)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>€{{ number_format($product['price_excl_vat'], 2, ',', '.') }}</td>
                    <td>€{{ number_format($product['price_incl_vat'], 2, ',', '.') }}</td>
                    <td>€{{ number_format($product['discounted_price_incl_vat'], 2, ',', '.') }}</td>
                    <td>€{{ number_format($product['total_excl_vat'], 2, ',', '.') }}</td>
                    <td>€{{ number_format($product['total_incl_vat'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
