<?php
namespace Models;
use Lib\BaseDatos;
use PDOException;
use PDO;

class Pedido{
    private string|null $id;
    private string $usuario_id;
    private string $provincia;
    private string $localidad;
    private string $direccion;
    private string $coste;
    private string $estado;
    private string $fecha;
    private string $hora;

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

	public function getUsuario_id() : string {
		return $this->usuario_id;
	}

	public function setUsuario_id(string $value) {
		$this->usuario_id = $value;
	}

	public function getProvincia() : string {
		return $this->provincia;
	}

	public function setProvincia(string $value) {
		$this->provincia = $value;
	}

	public function getLocalidad() : string {
		return $this->localidad;
	}

	public function setLocalidad(string $value) {
		$this->localidad = $value;
	}

	public function getDireccion() : string {
		return $this->direccion;
	}

	public function setDireccion(string $value) {
		$this->direccion = $value;
	}

	public function getCoste() : string {
		return $this->coste;
	}

	public function setCoste(string $value) {
		$this->coste = $value;
	}

	public function getEstado() : string {
		return $this->estado;
	}

	public function setEstado(string $value) {
		$this->estado = $value;
	}

	public function getFecha() : string {
		return $this->fecha;
	}

	public function setFecha(string $value) {
		$this->fecha = $value;
	}

	public function getHora() : string {
		return $this->hora;
	}

	public function setHora(string $value) {
		$this->hora = $value;
	}

	public function desconecta() : void{
        $this->db==null;
    }

    public function save(): bool {
        $id = NULL;
        
        // Obtiene los valores de las propiedades del objeto
        $usuario_id = $this->getUsuario_id();
        $provincia = $this->getProvincia();
        $localidad = $this->getLocalidad();
        $direccion = $this->getDireccion();
        $coste = $this->getCoste();
        $estado = $this->getEstado();
        $fecha = $this->getFecha();
        $hora = $this->getHora();
        
        try {
            // Prepara la consulta SQL para insertar un producto
            $ins = $this->db->prepare("INSERT INTO pedidos (id, usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora)
                                        VALUES (:id, :usuario_id, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)");
            
            // Vincula los parámetros
            $ins->bindValue( ':id', $id);
            $ins->bindValue(':usuario_id', $usuario_id);
            $ins->bindValue(':provincia', $provincia, PDO::PARAM_STR);
            $ins->bindValue(':localidad', $localidad, PDO::PARAM_STR);
            $ins->bindValue(':direccion', $direccion, PDO::PARAM_STR);
            $ins->bindValue(':coste', $coste, PDO::PARAM_INT); // Si stock es un número entero
            $ins->bindValue(':estado', $estado, PDO::PARAM_STR);
            $ins->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $ins->bindValue(':hora', $hora, PDO::PARAM_STR);
            // Ejecuta la consulta
            $ins->execute();

			$this->setId($this->db->lastInsertId());
            
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


	public function getPedidosByUsuarioId(string $usuario_id): array {
        try {
            // Prepara la consulta SQL para obtener los pedidos de un usuario
            $consulta = $this->db->prepare("SELECT * FROM pedidos WHERE usuario_id = :usuario_id");
            
            // Vincula el parámetro
            $consulta->bindValue(':usuario_id', $usuario_id);
            
            // Ejecuta la consulta
            $consulta->execute();
            
            // Obtiene todos los resultados como un array asociativo
            $pedidos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            
            return $pedidos;
        } catch (PDOException $e) {
            // Manejo de excepciones: Puedes realizar acciones aquí si ocurre un error en la consulta
            // Por ejemplo, puedes imprimir el error con: echo $e->getMessage();
            return []; // En caso de error, devuelve un array vacío
        } finally {
            $this->desconecta();
        }
    }



}