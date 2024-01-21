<?php
namespace Models;
use Lib\BaseDatos;
use PDOException;
use PDO;

class Categoria{
    private string $id;
    private string $nombre;
    private BaseDatos $db;


    public function __construct() {
		$this->db = new BaseDatos();
	}

	public function getId() : string {
		return $this->id;
	}

	public function setId(string $value) {
		$this->id = $value;
	}

	public function getNombre() : string {
		return $this->nombre;
	}

	public function setNombre(string $value) {
		$this->nombre = $value;
	}



	public function desconecta() : void{
        $this->db==null;
    }
	
public function getAll(){

	$categoria=$this->db->prepare("SELECT * FROM categorias ORDER BY id DESC");
	$categoria->execute();
	
	$categorias = $categoria->fetchAll(PDO::FETCH_OBJ);
	$categoria->closeCursor();
	$categoria=null;
	$this->desconecta();
		return $categorias;

}

public function save(): bool {
	$id = NULL;
	
	// Obtiene los valores de las propiedades del objeto
	$nombre = $this->getNombre();
	
	try {
		// Prepara la consulta SQL para insertar un producto
		$ins = $this->db->prepare("INSERT INTO categorias (id, nombre)
									VALUES (:id, :nombre)");
		
		// Vincula los parámetros
		$ins->bindValue( ':id', $id);
		$ins->bindValue(':nombre', $nombre, PDO::PARAM_STR);
		
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
    
}

	
