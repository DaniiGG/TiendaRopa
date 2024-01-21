<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pedido</title>
    <style>
        article{
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <h1>Recibo de Pedido</h1>

    <!-- Puedes mostrar la información del recibo aquí -->
    <article>
        
        <div>
        <!-- Puedes iterar sobre los productos y mostrar la información -->
            <p><b>Id del pedido</b> <?= $pedido ?></p>
            <ul>
                <?php foreach ($productos as $productoId => $productoInfo) : ?>
                    <li>
                        <b>Producto ID:</b> <?= $productoId ?><br>
                        <b>Nombre:</b> <?= $productoInfo['nombre'] ?><br>
                        <b>Cantidad:</b> <?= $productoInfo['cantidad'] ?><br>
                        <b>Precio Total:</b> <?= $productoInfo['precio_total'] ?> €<br>
                    </li><br>
                <?php endforeach; ?>
            </ul>


            <p><b>Precio a pagar:</b> <?= $totalPrecio ?> €</p><br><br>



            <form action="<?= BASE_URL ?>pedido/enviarCorreo" method="post">
                <input type="hidden" name="totalPrecio" value="<?= $totalPrecio ?>">
                <input type="hidden" name="productos" value="<?= htmlspecialchars(json_encode($productos)) ?>">
                <input type="hidden" name="pedidoId" value="<?= $pedido ?>">
                <input type="submit" value="Comprar">
            </form>
        </div>

            
    </article>
</body>
</html>