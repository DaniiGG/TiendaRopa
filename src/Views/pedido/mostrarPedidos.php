<!-- mostrarPedidos.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
    <style>body{font-family:'Arial',sans-serif;margin:20px}h1{color:#333;text-align:center}table{width:100%;border-collapse:collapse;margin-top:20px}th,td{padding:10px;text-align:left;border:1px solid #ddd}th{background-color:#f2f2f2}tr:hover{background-color:#f5f5f5}p{text-align:center;color:#888}</style>
</head>
<body>

<h1>Mis Pedidos</h1>

<?php if (!empty($pedidos)) : ?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Provincia</th>
                <th>Localidad</th>
                <th>Dirección</th>
                <th>Coste</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido) : ?>
                <tr>
                    <td><?php echo $pedido['id']; ?></td>
                    <td><?php echo $pedido['provincia']; ?></td>
                    <td><?php echo $pedido['localidad']; ?></td>
                    <td><?php echo $pedido['direccion']; ?></td>
                    <td><?php echo $pedido['coste']; ?></td>
                    <td><?php echo $pedido['estado']; ?></td>
                    <td><?php echo $pedido['fecha']; ?></td>
                    <td><?php echo $pedido['hora']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>No tienes pedidos realizados.</p>
<?php endif; ?>

</body>
</html>
