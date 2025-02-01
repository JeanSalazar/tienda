<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
        }
        .logo {
            max-width: 150px;
        }
        .boleta {
            margin-top: 20px;
        }
        .boleta table {
            width: 100%;
            border-collapse: collapse;
        }
        .boleta table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header with logo -->
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo de la Tienda" class="logo">

        <h2>Boleta de Compra</h2>
    </div>

    <!-- Order details -->
    <div class="boleta">
        <p><strong>Orden ID:</strong> {{ $orden->id }}</p>
        <p><strong>Cliente:</strong> {{ $orden->cliente->nombre }}</p>
        <p><strong>Fecha de compra:</strong> {{ $orden->fecha_compra }}</p>

        <!-- Products table -->
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orden->productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->pivot->cantidad }}</td>
                        <td>{{ number_format($producto->precio, 2) }}</td>
                        <td>{{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Cupon details -->
        @if($orden->cupon)
            <p><strong>Cupon Aplicado:</strong>
                @if($orden->cupon->tipo_descuento == 1)
                    Descuento por porcentaje: {{ $orden->cupon->valor_descuento }}%
                @else
                    Descuento fijo: S/. {{ number_format($orden->cupon->valor_descuento, 2) }}
                @endif
            </p>
        @else
            <p>No se aplicó ningún cupón</p>
        @endif

        <!-- Totals -->
        <p class="total"><strong>Subtotal:</strong> S/. {{ number_format($orden->importe_preliminar, 2) }}</p>
        <p class="total"><strong>Descuento:</strong> S/. {{ number_format($orden->importe_descuento, 2) }}</p>
        <p class="total"><strong>Importe IGV:</strong> S/. {{ number_format($orden->importe_igv, 2) }}</p>
        <p class="total"><strong>Importe Total:</strong> S/. {{ number_format($orden->importe_total, 2) }}</p>
    </div>

</body>
</html>
