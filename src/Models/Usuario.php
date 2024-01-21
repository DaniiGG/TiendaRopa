<?php
namespace Models;
use Lib\BaseDatos;
use PDOException;
use PDO;


class Usuario{
    private string|null $id;
    private string $nombre;
    private string $apellidos;
    private string $email; 
    private string $pass;
    private string $rol;
    private BaseDatos $db;
    // Errores
    // protected static $errores
    public function  __construct(string $id, string $nombre, string $apellidos, string $email, string $pass, string $rol)
    {
    $this->db = new BaseDatos();
    $this->id= $id;
    $this->nombre=$nombre;
    $this->apellidos=$apellidos;
    $this->email=$email;
    $this->pass=$pass;
    $this->rol=$rol;
    }

    public function getId(): string|null {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellidos(): string {
        return $this->apellidos;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPass(): string {
        return $this->pass;
    }

    public function getRol(): string {
        return $this->rol;
    }

    // Setters
    public function setId(string|null $id): void {
        $this->id = $id;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellidos(string $apellidos): void {
        $this->apellidos = $apellidos;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPass(string $pass): void {
        $this->pass = $pass;
    }

    public function setRol(string $rol): void {
        $this->rol = $rol;
    }

    public static function fromArray(array $data): Usuario
    {
    return new Usuario(
    $data['id'] ?? '',
    $data['nombre'] ?? '',
    $data['apellidos'] ?? '',
    $data['email'] ?? '',
    $data['pass'] ?? '',
    $data['rol'] ?? '',

    );
    }

public function desconecta() : void{
    $this->db==null;
}

    
public function save() { 
    //if(isset($contacto['Contacto']['id']
    if($this->getId()){
    return $this->update();
    } else {
    return $this->create();
    }
    }

    
    public function create(): bool {
        $id = NULL;
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $email = $this->getEmail();
        $pass = $this->getPass();
        $rol = 'user';
        $result = false;
    
        try {
            $ins = $this->db->prepare("INSERT INTO usuarios (id, nombre, apellidos, email, pass, rol) VALUES (:id, :nombre, :apellidos, :email, :pass, :rol)");
            $ins->bindValue(':id', $id);
            $ins->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $ins->bindValue(':apellidos', $apellidos, PDO::PARAM_STR);
            $ins->bindValue(':email', $email, PDO::PARAM_STR);
            $ins->bindValue(':pass', $pass, PDO::PARAM_STR);
            $ins->bindValue(':rol', $rol, PDO::PARAM_STR);
    
            $ins->execute();
            $result = true;
        } catch (PDOException $e) {
            $result = false;
        }
    
        $this->desconecta();
        return $result;
    }



    public function buscaMail($email): bool|object {
        $result = false;
    
        // Comprobar si existe el usuario
        $cons = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $cons->bindValue(':email', $email, PDO::PARAM_STR);
    
        try {
            $cons->execute();
    
            if ($cons && $cons->rowCount() == 1) {
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $err) {
            // Log or handle the exception
            // For example: error_log("Error in buscaMail(): " . $err->getMessage());
        }
    
        $this->desconecta();
        return $result;
    }

public function login(): bool|object{
    $result=false;
    $email=$this->email;
    $pass=$this->pass;

    $usuario=$this->buscaMail($email);

    if($usuario !== false){
        $verify =password_verify($pass,$usuario->pass);
        if($verify){
            $result=$usuario;
            $this->nombre=$usuario->nombre;
            $this->apellidos=$usuario->apellidos;
            $this->rol=$usuario->rol;
            $this->id=$usuario->id;

        }
        
    }
    $this->desconecta();
    return $result;
}

}