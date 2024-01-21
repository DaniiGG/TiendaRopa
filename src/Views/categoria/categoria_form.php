<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Agregar Producto</title>
</head>
<body>
<?php use Utils\Utils; ?>
<?php if(isset($_SESSION['categoria_added']) && $_SESSION['categoria_added'] == 'complete'): ?> 
    <strong class="alert_green">Registro completado correctamente</strong> 
    <?php elseif(isset($_SESSION['categoria_added']) && $_SESSION['categoria_added'] == 'failed'): ?> 
        <strong class="alert_red">Registro fallido, introduzca bien los datos</strong> 
        <?php endif; ?>
<?php Utils::deleteSession('categoria_added'); ?>
    <h1>Formulario para Agregar Categoria</h1>
    <form action="<?=BASE_URL?>categoria/agregarCategoria/" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <input type="submit" value="Agregar Categoria">
    </form>
</body>
</html>