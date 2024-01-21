<?php
namespace Controllers;
Use Lib\Pages;
use Models\Categoria;
use Models\Productos;
Use Utils\Utils;

class CategoriaController{
    private Pages $pages;




    function __construct(){

        $this->pages= new Pages();
        

    }


    public function registroCategoria(): void {
                
                // Pasar las materias a la vista del formulario
                $this->pages->render('categoria/categoria_form');
        
    }


    public function agregarCategoria(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                isset($_POST['nombre'])
            ) {
                $nombre = $_POST['nombre'];

                // Crear una instancia de Producto con los datos recibidos
               $categoria = new Categoria();
               $categoria->setNombre($nombre);
                

                // Guardar el nuevo producto en la base de datos
                $save = $categoria->save();

                if ($save) {
                    $_SESSION['categoria_added'] = "complete";
                } else {
                    $_SESSION['categoria_added'] = "failed";
                }
            } else {
                $_SESSION['categoria_added'] = "failed";
            }
        }

        // Redirigir a alguna página después de agregar el producto
        $this->pages->render('categoria/categoria_form');
    }


    public function obtenerCategoriasyProductos($id = null): void {
        $categoria = new Categoria(); 
        $categorias = $categoria->getAll();
    
        if ($id !== null) {
            $producto = new Productos();
            $productos = $producto->getAllByCategory($id);
    
            $this->pages->render('categoria/categoria', [
                'categorias' => $categorias,
                'productos' => $productos
            ]);
        } else {
            $this->pages->render('categoria/categoria', [
                'categorias' => $categorias
            ]);
        }
    }

    


}

