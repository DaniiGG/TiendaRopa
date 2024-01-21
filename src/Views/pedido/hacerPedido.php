<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pedido</title>
</head>
<body>
<?php use Utils\Utils; ?>
<?php if(isset($_SESSION['pedido_added']) && $_SESSION['pedido_added'] == 'complete'): ?> 
    <strong class="alert_green">Registro completado correctamente</strong> 
    <?php elseif(isset($_SESSION['pedido_added']) && $_SESSION['pedido_added'] == 'failed'): ?> 
        <strong class="alert_red">Registro fallido, introduzca bien los datos</strong> 
        <?php endif; ?>
<?php Utils::deleteSession('pedido_added'); ?>
    <h1>Formulario de Pedido</h1>

    <form action="<?= BASE_URL ?>pedido/guardarPedido/" method="post">

        <label for="provincia">Provincia:</label>
        <input type="text" name="provincia" required>

        <label for="localidad">Localidad:</label>
        <input type="text" name="localidad" required>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required>

        <input type="hidden" name="coste" value="<?= $coste ?> €" required>

        <button type="submit">Guardar Pedido</button>
    </form>
</body>
</html>
