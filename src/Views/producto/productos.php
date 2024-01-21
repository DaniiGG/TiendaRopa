<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       
    </style>
</head>
<body>

<?php use Utils\Utils; ?>
<?php if(isset($_SESSION['producto_deleted']) && $_SESSION['producto_deleted'] == 'complete'): ?> 
    <strong class="alert_green">Se ha borrado correctamente</strong> 
    <?php elseif(isset($_SESSION['producto_deleted']) && $_SESSION['producto_deleted'] == 'failed'): ?> 
        <strong class="alert_red">No se ha podido borrar</strong> 
        <?php elseif(isset($_SESSION['comprado']) && $_SESSION['comprado'] == 'comprado'): ?> 
        <strong class="alert_green">La compra se ha realizado exitosamente</strong> 
        <?php endif; ?>
<?php Utils::deleteSession('producto_deleted'); ?>
<?php Utils::deleteSession('comprado'); ?>
<br>

<h1>Lista de Productos</h1>
    <section id="productos-mostrar">
        
    <?php if (!empty($productos)) : ?>
        
            <?php foreach ($productos as $producto) : ?>
                <div>
                 <ul id="productos">
                    <li><img src="<?= $producto->imagen?>"></li>
                    <li><?= $producto->nombre ?></li>
                   
                    <li><?= $producto->descripcion ?></li>
                    <li><?= $producto->precio?> €</li>
                    <li class="comprar">
                    <?php if ((!isset($_SESSION['identity'])||($_SESSION['identity']->rol === 'user'))): ?>
                        <a class="añadir" href="<?=BASE_URL?>carrito/anadirAlCarrito/<?= $producto->id ?>">
                            Añadir al carrito
                        </a>
                    </li>
                    <?php else : ?>
                    <li>
                        <a class="admin" href="<?=BASE_URL?>producto/eliminarProducto/<?= $producto->id ?>">
                            Borrar producto
                        </a>
                    </li>
                    
                    <li>

                        <a class="admin" href="<?=BASE_URL?>producto/edicionProducto/<?= $producto->id ?>">
                            Editar producto
                        </a>
                    </li>
                    <?php endif; ?>
            </ul>
                </div>
            <?php endforeach; ?>
        
    <?php else : ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
    </section>
    
</body>
</html>