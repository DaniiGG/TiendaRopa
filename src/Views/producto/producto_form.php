<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Agregar Producto</title>
</head>
<body>
<?php use Utils\Utils; ?>
<?php if(isset($_SESSION['producto_added']) && $_SESSION['producto_added'] == 'complete'): ?> 
    <strong class="alert_green">Registro completado correctamente</strong> 
    <?php elseif(isset($_SESSION['producto_added']) && $_SESSION['producto_added'] == 'failed_db'): ?> 
        <strong class="alert_red">Registro fallido, introduzca bien los datos</strong> 
        <?php elseif(isset($_SESSION['producto_added']) && $_SESSION['producto_added'] == 'failed_move_upload'): ?> 
        <strong class="alert_red">Fallo al subir la imagen</strong> 
        <?php elseif(isset($_SESSION['producto_added']) && $_SESSION['producto_added'] == 'failed_no_file'): ?> 
        <strong class="alert_red">No se ha encontrado la imagen</strong> 
        <?php elseif(isset($_SESSION['producto_added']) && $_SESSION['producto_added'] == 'failed_missing_fields'): ?> 
        <strong class="alert_red">Registro fallido, introduzca todos los campos</strong> 
        <?php endif; ?>
<?php Utils::deleteSession('producto_added'); ?>
    <h1>Formulario para Agregar Producto</h1>
    <form action="<?=BASE_URL?>producto/agregarProducto/" method="post" enctype="multipart/form-data">
    <label for="categoria_id">Categoría:</label>
        <select id="categoria_id" name="categoria_id" required>
            <option value="" disabled selected>Selecciona una categoría</option>
            <?php
            
            foreach ($categorias as $categoria) {
                echo "<option value='" . $categoria->id . "'>" . $categoria->nombre . "</option>";
            }
            
            ?>
        </select><br><br><br>
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>
        
        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" required><br><br>
        
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required><br><br>
        
        <label for="oferta">Oferta:</label>
        <input type="text" id="oferta" name="oferta"><br><br>
        
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required><br><br>
        
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*"><br><br>
        
        <input type="submit" value="Agregar Producto">
    </form>
</body>
</html>