<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Editar Producto</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
<?php use Utils\Utils; ?>
<?php if(isset($_SESSION['producto_updated']) && $_SESSION['producto_updated'] == 'complete'): ?> 
    <strong class="alert_green">Registro completado correctamente</strong> 
<?php elseif(isset($_SESSION['producto_updated']) && $_SESSION['producto_updated'] == 'failed'): ?> 
    <strong class="alert_red">Registro fallido, introduzca bien los datos</strong> 
<?php elseif(isset($_SESSION['producto_updated']) && $_SESSION['producto_updated'] == 'vacio'): ?> 
    <strong class="alert_red">Registro fallido, no debe haber campos vacíos</strong> 
<?php elseif(isset($_SESSION['producto_updated']) && $_SESSION['producto_updated'] == 'numeros'): ?> 
    <strong class="alert_red">Registro fallido, stock y precio deben ser números</strong> 
<?php endif; ?>
<?php Utils::deleteSession('producto_updated'); ?>
    <h1>Formulario para Editar Producto</h1>
    <form action="<?=BASE_URL?>producto/editarProducto/<?= $producto->id ?>" method="post">
        <label for="categoria_id">Categoría:</label>
        <select id="categoria_id" name="categoria_id" required>
            <option value="" disabled selected>Selecciona una categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria->id ?>" <?= ($producto && $producto->categoria_id == $categoria->id) ? 'selected' : '' ?>>
                    <?= $categoria->nombre ?>
                </option>
            <?php endforeach; ?>
        </select><br><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $producto ? htmlspecialchars($producto->nombre) : '' ?>" required><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?= $producto ? htmlspecialchars($producto->descripcion) : '' ?></textarea><br><br>

        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" value="<?= $producto ? htmlspecialchars($producto->precio) : '' ?>" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?= $producto ? htmlspecialchars($producto->stock) : '' ?>" required><br><br>

        <label for="oferta">Oferta:</label>
        <input type="text" id="oferta" name="oferta" value="<?= $producto ? htmlspecialchars($producto->oferta) : '' ?>"><br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?= $producto ? $producto->fecha : '' ?>" required><br><br>

        <label for="imagen">Imagen:</label>
        <input type="text" id="imagen" name="imagen" value="<?= $producto ? htmlspecialchars($producto->imagen) : '' ?>"><br><br>

        <input type="submit" value="Editar Producto">
    </form>
</body>
</html>
