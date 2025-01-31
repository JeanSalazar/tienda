<!-- resources/views/emails/compra.blade.php -->
<h1>Gracias por tu compra en Nanotech Store</h1>
<p>Detalles de tu orden:</p>
<ul>
    <li>Número de Orden: {{ $orden->id }}</li>
    <li>Total: S/ {{ $orden->total }}</li>
    <li>Fecha de Entrega: {{ $orden->fecha_entrega }}</li>
</ul>