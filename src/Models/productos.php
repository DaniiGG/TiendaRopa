<?php
namespace Models;
use Lib\BaseDatos;
use PDOException;
use PDO;

class Productos{
    private string|null $id;
    private string $categoria_id;
    private string $nombre;
    private string $descripcion;
    private string $precio;
    private string $stock;
    private string $oferta;
    private string $fecha;
    private string $imagen;

    private BaseDatos $db;



    public function __construct() {

        $this->db = new BaseDatos();
	}
   
    public function getId() : string|null {
		return $this->id;
	}

	public function setId(string|null $value) {
		$this->id = $value;
	}

	public function getCategoria_id() : string {
		return $this->categoria_id;
	}

	public function setCategoria_id(string $value) {
		$this->categoria_id = $value;
	}

	public function getNombre() : string {
		return $this->nombre;
	}

	public function setNombre(string $value) {
		$this->nombre = $value;
	}

	public function getDescripcion() : string {
		return $this->descripcion;
	}

	public function setDescripcion(string $value) {
		$this->descripcion = $value;
	}

	public function getPrecio() : string {
		return $this->precio;
	}

	public function setPrecio(string $value) {
		$this->precio = $value;
	}

	public function getStock() : string {
		return $this->stock;
	}

	public function setStock(string $value) {
		$this->stock = $value;
	}

	public function getOferta() : string {
		return $this->oferta;
	}

	public function setOferta(string $value) {
		$this->oferta = $value;
	}

	public function getFecha() : string {
		return $this->fecha;
	}

	public function setFecha(string $value) {
		$this->fecha = $value;
	}

	public function getImagen() : string {
		return $this->imagen;
	}

	public function setImagen(string $value) {
		$this->imagen = $value;
	}

	


    public function desconecta() : void{
        $this->db==null;
    }
	
	
    public function save(): bool {
        $id = NULL;
        
        // Obtiene los valores de las propiedades del objeto
        $categoria_id = $this->getCategoria_id();
        $nombre = $this->getNombre();
        $descripcion = $this->getDescripcion();
        $precio = $this->getPrecio();
        $stock = $this->getStock();
        $oferta = $this->getOferta();
        $fecha = $this->getFecha();
        $imagen = $this->getImagen();
        
        try {
            // Prepara la consulta SQL para insertar un producto
            $ins = $this->db->prepare("INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
                                        VALUES (:id, :categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)");
            
            // Vincula los parámetros
            $ins->bindValue( ':id', $id);
            $ins->bindValue(':categoria_id', $categoria_id);
            $ins->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $ins->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $ins->bindValue(':precio', $precio, PDO::PARAM_STR);
            $ins->bindValue(':stock', $stock, PDO::PARAM_INT); // Si stock es un número entero
            $ins->bindValue(':oferta', $oferta, PDO::PARAM_STR);
            $ins->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $ins->bindValue(':imagen', $imagen, PDO::PARAM_STR);
            
            // Ejecuta la consulta
            $ins->execute();
            
            // Si se ejecuta correctamente, establece el resultado como verdadero
            $result = true;
        } catch (PDOException $e) {
            // Manejo de excepciones: Puedes realizar acciones aquí si ocurre un error en la consulta
            // Por ejemplo, puedes imprimir el error con: echo $e->getMessage();
            $result = false; // En caso de error, se establece el resultado como falso
        }
        $this->desconecta();
        
        return $result; // Retorna el resultado de la operación de inserción (true/false)
    }

	
    public function getAll(){

        $producto=$this->db->prepare("SELECT * FROM productos");
        $producto->execute();
        
        $productos = $producto->fetchAll(PDO::FETCH_OBJ);
        $producto->closeCursor();
        $producto=null;
        $this->desconecta();
            return $productos;
    }


    public function getById(string $id): ?object {
        $consulta = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        
        $producto = $consulta->fetch(PDO::FETCH_OBJ);
        $consulta->closeCursor();
        $this->desconecta();
        return $producto ?: null;
    }

    public function delete($idProducto): bool {
        try {
            // Prepara la consulta SQL para eliminar un producto por su ID
            $del = $this->db->prepare("DELETE FROM productos WHERE id = :id");
            
            // Vincula el parámetro
            $del->bindValue(':id', $idProducto);
            
            // Ejecuta la consulta
            $del->execute();
            
            // Verifica si se eliminó al menos un registro
            $rowsAffected = $del->rowCount(); // Obtiene el número de filas afectadas
            
            // Si se eliminó al menos una fila, se considera éxito en la eliminación
            $result = ($rowsAffected > 0);
        } catch (PDOException $e) {
            // Manejo de excepciones
            // Puedes imprimir el error con: echo $e->getMessage();
            $result = false; // En caso de error, se establece el resultado como falso
        }
        $this->desconecta();
        return $result; // Retorna el resultado de la operación de eliminación (true/false
    }



    public function getAllByCategory($idCategoria) {
        try {
            // Prepara la consulta SQL para seleccionar productos por categoría
            $consulta = $this->db->prepare("SELECT * FROM productos WHERE categoria_id = :idCategoria");
            
            // Vincula el parámetro
            $consulta->bindValue(':idCategoria', $idCategoria);
            
            // Ejecuta la consulta
            $consulta->execute();
            
            // Obtén los resultados
            $productos = $consulta->fetchAll(PDO::FETCH_OBJ);
            
            // Cierra el cursor y libera la conexión
            $consulta->closeCursor();
            $this->desconecta();
            return $productos; // Retorna los productos filtrados por la categoría especificada
        } catch (PDOException $e) {
            // Manejo de excepciones
            // Puedes imprimir el error con: echo $e->getMessage();
            return []; // En caso de error, retorna un array vacío o maneja el error según tu lógica
        }
        
    }



    public function actualizarProducto($id, $categoria_id, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $imagen) {
		try {
			$query = "UPDATE productos SET categoria_id  = :categoria_id, nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, oferta = :oferta, fecha = :fecha, imagen = :imagen WHERE id = :id";
			$statement = $this->db->prepare($query);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->bindParam(':categoria_id', $categoria_id , PDO::PARAM_STR);
			$statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
			$statement->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
			$statement->bindParam(':precio', $precio, PDO::PARAM_STR);
			$statement->bindParam(':stock', $stock, PDO::PARAM_STR);
			$statement->bindParam(':oferta', $oferta, PDO::PARAM_STR);
            $statement->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $statement->bindParam(':imagen', $imagen, PDO::PARAM_STR);
            
            $result = $statement->execute();
            
			$statement->closeCursor();
            $this->desconecta();
			return $result;
            
		} catch (PDOException $err) {
			return false;
		}
        
	}


    public function actualizarStock($id, $cantidad, $operacion = 'restar') {
        try {
            // Si la operación es 'restar', multiplicamos la cantidad por -1
            $cantidad = ($operacion === 'restar') ? -$cantidad : $cantidad;
    
            $query = "UPDATE productos SET stock = stock + :cantidad WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    
            $result = $statement->execute();
    
            $statement->closeCursor();
            $this->desconecta();
            return $result;
        } catch (PDOException $err) {
            return false;
        }
    }
	

 
}