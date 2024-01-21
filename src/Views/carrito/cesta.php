<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
       
        .section-carrito{
            display: flex;
            flex-wrap: wrap;
        }
    </style>
    
</head>
<body>
<?php use Utils\Utils; ?>
<?php
$totalPrecio = 0;
?>
    <h1>Carrito de Compras</h1>

    

    <section class="section-carrito">
        <div>
            <?php if (!empty($productosEnCarrito)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>&nbsp;&nbsp;Producto &nbsp;&nbsp;</th>
                            <th>Precio Ud.&nbsp;&nbsp;</th>
                            <th>Unidades&nbsp;&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productosEnCarrito as $producto) : ?>
                            <tr>
                                <td><img src="<?= BASE_URL . $producto->imagen ?>"></td>
                                <td>&nbsp;&nbsp;<?= $producto->nombre ?></td>
                                <td><?= $producto->precio ?> €</td>
                                <td>
                                    <a href="<?= BASE_URL ?>carrito/aumentarCantidad/<?= $producto->id ?>">+</a>
                                
                                <span><?= $_SESSION['carrito'][$producto->id] ?></span>
                                
                                    <a href="<?= BASE_URL ?>carrito/disminuirCantidad/<?= $producto->id ?>">-</a>
                                </td>
                                <td>
                                <a class="añadir" href="<?=BASE_URL?>carrito/eliminarDelCarrito/<?= $producto->id ?>">
                                    Eliminar
                                </a>
                                </td>
                            </tr>
                            <?php
                            // Actualizar el precio total en cada iteración del bucle
                            $totalPrecio += $producto->precio * $_SESSION['carrito'][$producto->id];
                            ?>
                        <?php endforeach; ?>
                        <tr>
                            <!-- Añadir una fila para mostrar el precio total -->
                            <td colspan="2"></td>
                            <th>Precio Total:</th>
                            <td><?= $totalPrecio ?> €</td>
                            <td><a class="añadir" href="<?=BASE_URL?>pedido/mostrarFormulario/<?= $totalPrecio ?>">Hacer Pedido</a></td>
                        </tr>
                    </tbody>
                </table>
                
            <?php else : ?>
                <p>El carrito está vacío</p>
            <?php endif; ?>
        </div>
        <div>
            <?php if(isset($_SESSION['pedido_added']) && $_SESSION['pedido_added'] == 'complete'): ?> 
                    <?php if (!empty($productosEnCarrito)) : ?>
                        <form action="<?= BASE_URL ?>pedido/mostrarRecibo" method="post">
                            <?php foreach ($productosEnCarrito as $producto) : ?>
                                <div>
                                    <input type="hidden" id="producto_<?= $producto->id ?>" name="productos[<?= $producto->id ?>][nombre]" value="<?= $producto->nombre ?>">
                                    
                                    <input type="hidden" id="cantidad_<?= $producto->id ?>" name="productos[<?= $producto->id ?>][cantidad]" value="<?= $_SESSION['carrito'][$producto->id] ?>">
                                
                                    <input type="hidden" id="precio_<?= $producto->id ?>" name="productos[<?= $producto->id ?>][precio]" value="<?= $producto->precio ?>">

                                </div>
                            <?php endforeach; ?>

                                <input type="hidden" id="totalPrecio" name="totalPrecio" value="<?= $totalPrecio ?>">
                           

                            
                                <input type="hidden" id="pedido_id" name="pedido_id" value="<?= $_SESSION['pedido_id'] ?>">
                           
                                <input type="submit" value="Ir a pantalla de compra">
                            
                        </form>
                    <?php endif; ?>
                    
                        <?php endif; ?>
                <?php Utils::deleteSession('pedido_added'); ?>
         </div>
    </section>
</body>
</html>
