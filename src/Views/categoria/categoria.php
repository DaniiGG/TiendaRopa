<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
     .listacategorias {
        text-align: center;
    list-style: none;
    padding: 0;
    margin: 0;
}
.listacategorias li {
    display: inline-block;
    margin-right: 10px; /* Espacio entre elementos */
}

        section{
            display: flex;
            justify-content: space-evenly;
        }
     #productos {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: center;
}
#productos li{
    margin: 10px;
}


   
    </style>
</head>
<body>
<h1>Lista de Categorías</h1>
    
    <?php if (!empty($categorias)) : ?>
        <ul class="listacategorias">
            <?php foreach ($categorias as $categoria) : ?>
               
                <li class="categorias">

                    <a  href="<?= BASE_URL ?>categoria/obtenerCategoriasyProductos/<?=$categoria->id ?>">
                          
                        <?= $categoria->nombre ?>
                    </a>
                        
                </li>
                   
                    
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No hay categorías disponibles.</p>
    <?php endif; ?>

    
    <section>
        
    <?php if (!empty($productos)) : ?>
        
            <?php foreach ($productos as $producto) : ?>
                <div>
                 <ul id="productos">
                    <li><img src="<?= BASE_URL . $producto->imagen ?>"></li>
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




   