<!-- resources/views/boleta.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Boleta Electrónica - Nanotech Store</title>
</head>
<body>
    <h1>Boleta Electrónica</h1>
    <p>Número de Orden: {{ $orden->id }}</p>
    <p>Cliente: {{ $orden->usuario->nombre }}</p>
    <p>Total: S/ {{ $orden->total }}</p>
    <p>Fecha de Entrega: {{ $orden->fecha_entrega }}</p>
</body>
</html>