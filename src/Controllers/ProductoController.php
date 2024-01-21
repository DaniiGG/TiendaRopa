<?php
namespace Controllers;
Use Lib\Pages;
use Models\Productos;
use Models\Categoria;
Use Utils\Utils;

class ProductoController{
    private Pages $pages;




    function __construct(){

        $this->pages= new Pages();
        

    }
    public function registroProducto(): void {
        $categoria = new Categoria();
                $categorias = $categoria->getAll(); // Obtener todas las materias
                
                // Pasar las materias a la vista del formulario
                $this->pages->render('producto/producto_form', ['categorias' => $categorias]);
        
    }

    public function agregarProducto(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                isset($_POST['categoria_id'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])
            ) {
                $categoria_id = $_POST['categoria_id'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = $_POST['precio'];
                $stock = $_POST['stock'];
                $oferta = $_POST['oferta'];
                $fecha = $_POST['fecha'];
    
                // Manejar la carga de la imagen
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'img/';
                    
                    // Verificar si el directorio existe, si no, créalo
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
    
                    $uploadFile = $uploadDir . basename($_FILES['imagen']['name']);
    
                    // Mover la imagen a la carpeta de destino
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                        // Guardar la ruta de la imagen en la base de datos
                        $imagen = $uploadFile;
    
                        // Crear una instancia de Producto con los datos recibidos
                        $producto = new Productos();
                        $producto->setCategoria_id($categoria_id);
                        $producto->setNombre($nombre);
                        $producto->setDescripcion($descripcion);
                        $producto->setPrecio($precio);
                        $producto->setStock($stock);
                        $producto->setOferta($oferta);
                        $producto->setFecha($fecha);
                        $producto->setImagen($imagen);
    
                        // Guardar el nuevo producto en la base de datos
                        $save = $producto->save();
    
                        if ($save) {
                            $_SESSION['producto_added'] = "complete";
                        } else {
                            $_SESSION['producto_added'] = "failed_db";
                        }
                    } else {
                        $_SESSION['producto_added'] = "failed_move_upload";
                    }
                } else {
                    $_SESSION['producto_added'] = "failed_no_file";
                }
            } else {
                $_SESSION['producto_added'] = "failed_missing_fields";
            }
        }
    
        // Redirigir a alguna página después de agregar el 
        header("Location:".BASE_URL."producto/registroProducto/"); 
                    exit;
    }



    public function obtener():void{
        
        $producto = new Productos(); 
    
        $productos = $producto->getAll();
        $this->pages->render('producto/productos', ['productos' => $productos]);
    
    
    }

    public function eliminarProducto($idProductoEliminar): void {
        // Verificar si se proporcionó un ID válido para eliminar
        if (!empty($idProductoEliminar)) {
            
            // Crear una instancia de Productos
            $producto = new Productos();
            
            // Intentar eliminar el producto usando el método delete
            $resultadoEliminacion = $producto->delete($idProductoEliminar);
            
            if ($resultadoEliminacion) {
                $_SESSION['producto_deleted'] = "complete"; // Marcar como completado si se elimina correctamente
            } else {
                $_SESSION['producto_deleted'] = "failed"; // Marcar como fallido si hay algún error al eliminar
            }
        } else {
            $_SESSION['producto_deleted'] = "failed"; // Si no se proporciona un ID válido, marcar como fallido
        }
    
        // Redirigir a alguna página después de eliminar el producto
        header("Location:".BASE_URL."/"); 
    }




    public function editarProducto($id): void {
        $productoModelo = new Productos();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['categoria_id'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'], $_POST['imagen'])
        ) {
            $categoria_id = $_POST['categoria_id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $fecha = $_POST['fecha'];
            $imagen = $_POST['imagen'];
    
            // Validaciones
            if (empty($categoria_id) || empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) || empty($fecha) || empty($imagen)) {
                $_SESSION['producto_updated'] = "vacio";
                // Puedes agregar un mensaje más específico según tus necesidades
            } elseif (!is_numeric($precio) || !is_numeric($stock)) {
                $_SESSION['producto_updated'] = "numeros";
                // Puedes agregar un mensaje indicando que los campos de precio y stock deben ser números
            } else {
                // Crear una instancia de Producto con los datos recibidos
    
                // Actualizar el producto en la base de datos
                $update = $productoModelo->actualizarProducto($id, $categoria_id, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $imagen);
    
                if ($update) {
                    $_SESSION['producto_updated'] = "complete";
                } else {
                    $_SESSION['producto_updated'] = "failed";
                }
            }
        } else {
            $_SESSION['producto_updated'] = "failed";
        }
    
        // Obtener los datos del producto para prellenar el formulario de edición
        $producto = $productoModelo->getById($id);
        $categoria = new Categoria();
    
        $categorias = $categoria->getAll();
    
        // Renderizar el formulario de edición con los datos del producto
        $this->pages->render('producto/producto_edit', ['producto' => $producto, 'categorias' => $categorias]);
    }
    

    public function edicionProducto($id): void {
        $categoria = new Categoria();

        $categorias = $categoria->getAll(); 

        $productoModelo = new Productos(); // Asegúrate de que el nombre del modelo sea correcto
        $producto = $productoModelo->getById($id);

                
         $this->pages->render('producto/producto_edit',[
            'producto' => $producto,
            'categorias' => $categorias
        ]);
        
    }


    
}

