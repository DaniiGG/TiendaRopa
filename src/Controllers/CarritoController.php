<?php

namespace Controllers;

use Lib\Pages;
use Models\Productos;

class CarritoController {
    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }

    public function añadirAlCarrito($id): void {
        // Validar si se proporcionó un ID de producto válido
        if (!empty($id)) {
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }
    
            $productoModel = new Productos(); 
            $producto = $productoModel->getById($id);
    
            if ($producto && isset($_SESSION['carrito'][$id])) {
                // Verificar si la cantidad en el carrito más la que se quiere añadir supera el stock disponible
                if ($_SESSION['carrito'][$id] + 1 > $producto->stock) {
                    header("Location:".BASE_URL."carrito/mostrarCarrito/"); 
                    exit;
                }
            }
    
            // Añadir el producto al carrito o incrementar su cantidad si ya existe
            if (isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id]++;
            } else {
                $_SESSION['carrito'][$id] = 1;
            }
    
            $this->mostrarCarrito();
            return;
        } else {
            echo('Error: No se proporcionó un ID de producto válido');
        }
    }
    

    public function mostrarCarrito(): void {
        
        $productosEnCarrito = $this->obtenerProductosEnCarrito();

        $this->pages->render('carrito/cesta', ['productosEnCarrito' => $productosEnCarrito]);
    }

    public function eliminarDelCarrito($id): void {
        if (!empty($id)) {
            if (isset($_SESSION['carrito'][$id])) {
                unset($_SESSION['carrito'][$id]);
            }
    
            $this->mostrarCarrito();
            return;
        } else {
            echo('Error al eliminar el producto del carrito');
        }
    }

    public function aumentarCantidad($id): void {
        if (!empty($id)) {
            if (!isset($_SESSION['carrito'])) {
                echo('El carrito está vacío');
                return;
            }
    
            $productoModel = new Productos(); 
            $producto = $productoModel->getById($id);
    
            if ($producto && isset($_SESSION['carrito'][$id])) {
                // Verificar si la cantidad en el carrito más la que se quiere añadir supera el stock disponible
                if ($_SESSION['carrito'][$id] + 1 > $producto->stock) {
                    
                    header("Location:".BASE_URL."carrito/mostrarCarrito/"); 
                    exit;
                    
                }
            }
    
            // Incrementar la cantidad del producto en el carrito
            if (isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id]++;
            }
    
            $this->mostrarCarrito();
            return;
        } else {
            echo('Error al aumentar la cantidad del producto en el carrito');
        }
    }
    
    public function disminuirCantidad($id): void {
        if (!empty($id)) {
            if (isset($_SESSION['carrito'][$id]) && $_SESSION['carrito'][$id] > 1) {
                $_SESSION['carrito'][$id]--;
            } elseif ($_SESSION['carrito'][$id] === 1) {
                unset($_SESSION['carrito'][$id]);
            }
    
            $this->mostrarCarrito();
            return;
        } else {
            echo('Error al disminuir la cantidad del producto en el carrito');
        }
    }
    

    private function obtenerProductosEnCarrito(): array {
        $idsProductosEnCarrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
        $productosEnCarrito = [];

        $productoModel = new Productos(); 

        foreach ($idsProductosEnCarrito as $idProducto => $cantidad) {
            $producto = $productoModel->getById($idProducto);

            if ($producto) {
                $producto->cantidad = $cantidad;
                $productosEnCarrito[] = $producto;
            }
        }

        return $productosEnCarrito;
    }
}
