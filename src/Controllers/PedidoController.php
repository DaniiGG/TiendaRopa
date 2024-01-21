<?php

namespace Controllers;

use Lib\Pages;
use Models\Pedido;
use Models\Productos;


class PedidoController {
    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }



    public function mostrarFormulario($id): void {
        // Recupera el valor del costo desde el parámetro
        
        $coste = $id;
   
        // Puedes cargar una vista con el formulario aquí, pasando el costo como variable
        $this->pages->render('pedido/hacerPedido', ['coste' => $coste]);
    }

    public function guardarPedido(): void {
        // Verifica si el usuario ha iniciado sesión y obtén su ID
        if (isset($_SESSION['identity'])) {
            $usuario_id = $_SESSION['identity']->id;
        } else {
            $_SESSION['register'] = "carrito";
            // Si no ha iniciado sesión, redirige a la página de inicio de sesión o muestra un mensaje de error
            header("Location: " . BASE_URL . "usuario/login/");
            exit;
        }
    
        // Obtén los demás datos del formulario (puedes validarlos aquí según tus necesidades)
        $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : '';
        $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : '';
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
        $coste = isset($_POST['coste']) ? $_POST['coste'] : '';
        $estado = 'Pendiente';
    
        // Verificar que los campos obligatorios no estén vacíos
        if (empty($provincia) || empty($localidad) || empty($direccion) || empty($coste)) {
            $_SESSION['pedido_added'] = "failed_empty_fields";
        }
    
        // Obtén la fecha y hora actuales
        $fecha = date("Y-m-d"); // Formato: Año-Mes-Día
        $hora = date("H:i:s"); // Formato: Hora:Minuto:Segundo
    
        // Crear un objeto Pedido
        $pedido = new Pedido();
        $pedido->setUsuario_id($usuario_id);
        $pedido->setProvincia($provincia);
        $pedido->setLocalidad($localidad);
        $pedido->setDireccion($direccion);
        $pedido->setCoste($coste);
        $pedido->setEstado($estado);
        $pedido->setFecha($fecha);
        $pedido->setHora($hora);
    
        // Intentar guardar el pedido en la base de datos
        $resultado = $pedido->save();
    
        // Puedes redirigir a una página de éxito o mostrar un mensaje según el resultado
        if ($resultado) {
            $_SESSION['pedido_id'] = $pedido->getId();
            $_SESSION['pedido_added'] = "complete";
            header("Location: " . BASE_URL . "carrito/mostrarCarrito");
            exit;
        } else {
            $_SESSION['pedido_added'] = "failed";
        }
    
        $this->pages->render('pedido/hacerPedido');
    }
    

    public function procesarPedido(): void {
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            $productoModel = new Productos();

            foreach ($_SESSION['carrito'] as $id => $cantidad) {
                $producto = $productoModel->getById($id);

                if ($producto && $producto->stock >= $cantidad) {
                    $nuevoStock = $producto->stock - $cantidad;
                    $productoModel->actualizarStock($id, $nuevoStock);

                    unset($_SESSION['carrito'][$id]);
                } else {
                    echo "Error: No hay suficiente stock para el producto con ID $id";
                    return;
                }
            }

            // Puedes realizar otras acciones relacionadas con el pedido aquí

            header("Location:".BASE_URL."/");
            exit;
        } else {
            echo "Error: El carrito está vacío";
        }
    }

    public function mostrarPedidosUsuario(): void {
        // Verifica si el usuario ha iniciado sesión y obtén su ID
        if (isset($_SESSION['identity'])) {
            $usuario_id = $_SESSION['identity']->id;
        } else {
            // Si no ha iniciado sesión, redirige a la página de inicio de sesión o muestra un mensaje de error
            header("Location: " . BASE_URL . "usuario/login/");
            exit;
        }

        // Crea un objeto Pedido
        $pedido = new Pedido();

        // Obtiene los pedidos del usuario
        $pedidos = $pedido->getPedidosByUsuarioId($usuario_id);

        // Puedes cargar una vista con los pedidos aquí, pasando la lista de pedidos como variable
        $this->pages->render('pedido/mostrarPedidos', ['pedidos' => $pedidos]);
    }

}
