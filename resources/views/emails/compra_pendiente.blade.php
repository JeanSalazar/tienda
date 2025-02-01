<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra pendiente</title>
</head>
<body>
    <h1>Hola, {{ $orden->cliente->nombre }}</h1>
    <p>Gracias por tu compra en nuestra tienda <b>"Nanotech Store"</b>. Tu orden está pendiente de revisión de pago.</p>
    <p>Detalles de la orden:</p>
    <ul>
        <li>Orden ID: {{ $orden->id }}</li>
        <li>Fecha de compra: {{ $orden->fecha_compra }}</li>
        <li>Importe total: {{ $orden->importe_total }}</li>
        <li>Estado: Pendiente de pago</li>
    </ul>
    <p>Nos pondremos en contacto contigo una vez que la revisión del pago esté completa.</p>
</body>
</html>