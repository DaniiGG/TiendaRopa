<?php
namespace Models;
use Lib\BaseDatos;
use PDOException;
use PDO;

class Lineas_Pedido{
    private string|null $id;
    private string $pedido_id;
    private string $producto_id;
    private string $unidades;
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

	public function getPedido_id() : string {
		return $this->pedido_id;
	}

	public function setPedido_id(string $value) {
		$this->pedido_id = $value;
	}

	public function getProducto_id() : string {
		return $this->producto_id;
	}

	public function setProducto_id(string $value) {
		$this->producto_id = $value;
	}

	public function getUnidades() : string {
		return $this->unidades;
	}

	public function setUnidades(string $value) {
		$this->unidades = $value;
	}
	
    public function desconecta() : void{
        $this->db==null;
    }

    public function save(): bool {
        $id = NULL;
        
        // Obtiene los valores de las propiedades del objeto
        $pedido_id = $this->getPedido_id();
        $producto_id = $this->getProducto_id();
        $unidades = $this->getUnidades();
        
        try {
            // Prepara la consulta SQL para insertar un producto
            $ins = $this->db->prepare("INSERT INTO lineas_pedidos (id, pedido_id, producto_id, unidades)
                                        VALUES (:id, :pedido_id, :producto_id, :unidades)");
            
            // Vincula los parámetros
            $ins->bindValue( ':id', $id);
            $ins->bindValue(':pedido_id', $pedido_id);
            $ins->bindValue(':producto_id', $producto_id, PDO::PARAM_STR);
            $ins->bindValue(':unidades', $unidades, PDO::PARAM_STR);
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