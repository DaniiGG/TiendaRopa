<?php

namespace Routes;

use Controllers\CarritoController;
use Controllers\CategoriaController;
use Controllers\DashBoardController;
use Controllers\lineasPedidoController;
use Controllers\PedidoController;
use Controllers\ProductoController;
use Controllers\UsuarioController;
use Controllers\ErrorController;
use Lib\Router;

class Routes
{
    public static function index(){

        if ((isset($_SESSION['identity']))&&$_SESSION['identity']->rol === 'admin'){

            //AÑADIR CATEGORIA

            Router::add('GET','categoria/registroCategoria/',function (){
                return (new CategoriaController())->registroCategoria();
            });

            Router::add('POST','categoria/agregarCategoria/',function (){
                return (new CategoriaController())->agregarCategoria();
            });

            //AÑADIR PRODUCTO

            Router::add('GET','producto/registroProducto/',function (){
                return (new ProductoController())->registroProducto();
            });
        
            Router::add('POST','producto/agregarProducto/',function (){
                return (new ProductoController())->agregarProducto();
            });
    
    
            //ELIMINAR
            Router::add('GET','producto/eliminarProducto/:id',function ($id){
                return (new ProductoController())->eliminarProducto($id);
            });
    
            //EDITAR
            Router::add('GET','producto/edicionProducto/:id',function ($id){
                return (new ProductoController())->edicionProducto($id);
            });
    
            
            Router::add('POST','producto/editarProducto/:id',function ($id){
                return (new ProductoController())->editarProducto($id);
            });


        }
        
        Router::add('GET','/',function (){
            return (new ProductoController())->obtener();
        });

        


        Router::add('GET', 'categoria/obtenerCategoriasyProductos/:id', function ($id){
            return (new CategoriaController())->obtenerCategoriasyProductos($id);
        });

        Router::add('GET', 'categoria/obtenerCategoriasyProductos/', function (){
            return (new CategoriaController())->obtenerCategoriasyProductos();
        });


        //LOGIN Y REGISTRO
        Router::add('GET','usuario/login/',function (){
            return (new UsuarioController())->identifica();
            
        });

        Router::add('POST','usuario/login',function (){
            return (new UsuarioController())->login();
        });

        Router::add('GET','usuario/registro/',function (){
            return (new UsuarioController())->registro();
        });

        Router::add('POST','usuario/registro/',function (){
            return (new UsuarioController())->registro();
        });

        Router::add('GET','usuario/logout/',function (){
            return (new UsuarioController())->logout();
        });

        //AÑADIR

        
        

        //CARRITO
        Router::add('GET','carrito/mostrarCarrito/',function (){
            return (new CarritoController())->mostrarCarrito();
        });

        Router::add('GET','carrito/anadirAlCarrito/:id',function ($id){
            return (new CarritoController())->añadirAlCarrito($id);
        });

        Router::add('GET','carrito/aumentarCantidad/:id',function ($id){
            return (new CarritoController())->aumentarCantidad($id);
        });

        Router::add('GET','carrito/disminuirCantidad/:id',function ($id){
            return (new CarritoController())->disminuirCantidad($id);
        });

        Router::add('GET','carrito/eliminarDelCarrito/:id',function ($id){
            return (new CarritoController())->eliminarDelCarrito($id);
        });

        //PEDIDOS
        Router::add('GET','pedido/mostrarFormulario/:id',function ($id){
            return (new PedidoController())->mostrarFormulario($id);
        });

      

        Router::add('POST','pedido/guardarPedido/',function (){
            return (new PedidoController())->guardarPedido();
        });

        Router::add('POST','pedido/mostrarRecibo/',function (){
            return (new lineasPedidoController())->mostrarRecibo();
        });


        Router::add('POST','pedido/enviarCorreo/',function (){
            return (new lineasPedidoController())->enviarCorreo();
        });




        Router::add('GET','/Error/error/', function (){
            return (new errorController())->error404();
        });
        
        Router::dispatch();
    }
}