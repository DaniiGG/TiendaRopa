<?php

namespace Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Lib\Pages;
use Models\Lineas_Pedido;
use Models\Productos;

class lineasPedidoController {
    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }


    public function mostrarRecibo() {
        // Obtener la información del formulario
        $productos = $_POST['productos']; 
        $totalPrecio = $_POST['totalPrecio'];
        $pedidoId = $_POST['pedido_id'];
    
        // Calcular el precio total por producto
        foreach ($productos as &$producto) {
            $producto['precio_total'] = $producto['cantidad'] * $producto['precio'];
        }
    
        $data = [
            'totalPrecio' => $totalPrecio,
            'productos' => $productos,
            'pedido' => $pedidoId,
        ];
    
        $this->pages->render('pedido/mostrarRecibo', $data);
    }


    public function enviarCorreo() {
        // Obtener la información del formulario
        $totalPrecio = $_POST['totalPrecio'];
        $productos = json_decode($_POST['productos'], true);
        $pedidoId = $_POST['pedidoId'];
    
        // Calcular el precio total por producto
        foreach ($productos as &$producto) {
            $producto['precio_total'] = $producto['cantidad'] * $producto['precio'];
        }
    
        // Crear el contenido del correo electrónico
        $mensaje = '<h1>Recibo de Pedido</h1>';
        $mensaje .= '<p><b>Id del pedido:</b> ' . $pedidoId . '</p>';
        $mensaje .= '<p>Precio a pagar: ' . $totalPrecio . ' €</p>';
    
        $mensaje .= '<ul>';
        foreach ($productos as $productoId => $productoInfo) {
            $mensaje .= '<li>';
            $mensaje .= '<b>Producto ID:</b> ' . $productoId . '<br>';
            $mensaje .= '<b>Nombre:</b> ' . $productoInfo['nombre'] . '<br>';
            $mensaje .= '<b>Cantidad:</b> ' . $productoInfo['cantidad'] . '<br>';
            $mensaje .= '<b>Precio Total:</b> ' . $productoInfo['precio_total'] . ' €<br>';
            $mensaje .= '</li>';
        }
        $mensaje .= '</ul>';
    
        // Configurar PHPMailer
        $mail = new PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // proveedor de correo
            $mail->SMTPAuth = true;
            $mail->Username = 'pruebasphpdanii@gmail.com'; // Tu dirección de Gmail
            $mail->Password = 'fiqe mevv lxjo yhqn';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            $mail->setFrom('pruebasphpdanii@gmail.com', 'Tienda');
            $mail->addAddress('daniiggsmurf@gmail.com', 'comprador');
            $mail->isHTML(true);
            $mail->Subject = 'Recibo de Pedido';
            $mail->Body = $mensaje;
    
            // Enviar el correo electrónico
            $mail->send();
    
            // Insertar en la base de datos
            $lineasPedido = new Lineas_Pedido();
            $lineasPedido->setPedido_id($pedidoId);
    
            foreach ($productos as $productoId => $productoInfo) {
                $lineasPedido->setProducto_id($productoId);
                $lineasPedido->setUnidades($productoInfo['cantidad']);
                $lineasPedido->save();

                $productosModel = new Productos();
                $productosModel->actualizarStock($productoId, $productoInfo['cantidad'], 'restar');
            }
            unset($_SESSION['carrito']);
            
    
            // Redirigir o mostrar algún mensaje de éxito, etc.
            $_SESSION['comprado'] = "comprado";
            // Si no ha iniciado sesión, redirige a la página de inicio de sesión o muestra un mensaje de error
            header("Location: " . BASE_URL . "/");
            exit;
    
        } catch (Exception $e) {
            // Manejar errores en el envío del correo electrónico
            echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
            error_log('Error al enviar el correo: ' . $mail->ErrorInfo); // Registrar en el servidor
        }
    }
   
}
