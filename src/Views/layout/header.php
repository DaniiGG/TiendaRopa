<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
</head>
<body>

<header>

    <nav>
        <ul>
            <?php if(!isset($_SESSION['identity'])): ?>
                <li><a href="<?=BASE_URL?>/">Ver productos</a></li> 
                <li><a href="<?=BASE_URL?>categoria/obtenerCategoriasyProductos/1">Categorias</a></li>
                <li><a href="<?=BASE_URL?>carrito/mostrarCarrito/">Ver Carrito</a></li> 
                <li><a href="<?=BASE_URL?>usuario/login/">Iniciar sesión</a></li> 
                <li><a href="<?=BASE_URL?>usuario/registro/">¿No esta registrado?</a></li> 
                
                <?php elseif ($_SESSION['identity']->rol === 'admin'): ?>
            <h3> Bienvenido <?=$_SESSION['identity']->nombre?> 
            <?=$_SESSION['identity']->apellidos?></h3>
            <li><a href="<?=BASE_URL?>/">Ver productos</a></li> 
                <li><a href="<?=BASE_URL?>categoria/obtenerCategoriasyProductos/1">Categorias</a></li> 
                <li><a href="<?=BASE_URL?>categoria/registroCategoria/">Añadir Categorias</a></li> 
            <li><a href="<?=BASE_URL?>producto/registroProducto/">Agregar producto</a></li> 
            <hr>
            <li><a href="<?=BASE_URL?>usuario/logout/">Cerrar Sesión</a></li> 


            <?php elseif ($_SESSION['identity']->rol === 'user'): ?>
            <h3> Bienvenido <?=$_SESSION['identity']->nombre?> 
            <?=$_SESSION['identity']->apellidos?></h3>

            <li><a href="<?=BASE_URL?>/">Ver productos</a></li> 
            <li><a href="<?=BASE_URL?>categoria/obtenerCategoriasyProductos/1">Categorias</a></li> 
            <li><a href="<?=BASE_URL?>pedido/mostrarPedidosUsuario/">Ver mis pedidos</a></li> 
            
            <li><a href="<?=BASE_URL?>carrito/mostrarCarrito/">Ver Carrito</a></li> 
            <hr>
            <li><a href="<?=BASE_URL?>usuario/logout/">Cerrar Sesión</a></li> 
            <?php endif; ?>
        </ul>
    </nav>
<header>
</body>

