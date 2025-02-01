<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 150px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            font-size: 16px;
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid #ddd;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
        .total {
            margin-top: 20px;
            text-align: right;
        }
        .total p {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <!-- Logo -->
        <img src="{{ asset('assets/logo.png') }}" alt="Logo de la tienda">
        <h1>Boleta de Compra</h1>
        <p>Cliente: {{ $orden->cliente->nombre }}</p>
        <p>Fecha: {{ \Carbon\Carbon::parse($orden->fecha_compra)->format('d/m/Y') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orden->productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->pivot->cantidad }}</td>
                    <td>{{ number_format($producto->precio, 2) }}</td>
                    <td>{{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total: S/. {{ number_format($orden->importe_total, 2) }}</p>
        <p>IGV (18%): S/. {{ number_format($orden->importe_igv, 2) }}</p>
        <p><strong>Total a Pagar: S/. {{ number_format($orden->importe_venta, 2) }}</strong></p>
    </div>

</body>
</html>
