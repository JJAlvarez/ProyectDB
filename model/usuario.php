<?php

class Usuario {
    
    private $conn;
    private $table_name = "usuario";

    public $id_u;
    public $nombre;
    public $apellido;
    public $correo;
    public $contrasena;
    public $telefono;
    public $id_r;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    function login() {
        // query to read single record
        $query = "select * from login as u WHERE u.correo = :correo AND U.contrasena = :contrasena LIMIT 0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of usuario to be updated
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':contrasena', $this->contrasena);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->id_u = $row['id_u'];
        $this->nombre = $row['nombre'];
        $this->apellido = $row['apellido'];
        $this->correo = $row['correo'];
        $this->telefono = $row['telefono'];
        $this->id_r = $row['id_r'];
        $this->contrasena = null;
    }

    function updatePassword() {
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    contrasena = :contrasena
                WHERE
                    id_u = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->contrasena=htmlspecialchars(strip_tags($this->contrasena));
        $this->id_u=htmlspecialchars(strip_tags($this->id_u));
    
        // bind new values
        $stmt->bindParam(':contrasena', $this->contrasena);
        $stmt->bindParam(':id', $this->id_u);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function pay() {
        // update query
        $preQuery = "DELETE FROM subscripcion_usuario WHERE id_u=:id_u";

        $query = "INSERT INTO subscripcion_usuario
                SET
                    id_u = :id_u, id_s = 2, fecha_v = DATE_ADD(NOW(), INTERVAL 1 YEAR)";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($preQuery);
    
        // bind new values
        $stmt->bindParam(':id_u', $this->id_u);
        $stmt2->bindParam(':id_u', $this->id_u);
    
        // execute the query
        if($stmt2->execute() && $stmt->execute()){
            return true;
        }
    
        return false;
    }

    // leer usuarios
    function read(){
    
        // select all query
        $query = "SELECT u.id_u,
                    u.nombre,
                    u.apellido,
                    u.correo,
                    u.telefono,
                    ur.id_r AS id_r,
                    r.nombre AS nombre_rol
            FROM usuario AS u
                    INNER JOIN usuario_rol AS ur ON u.id_u = ur.id_u
                    INNER JOIN rol AS r ON ur.id_r = r.id_r
            GROUP BY u.id_u";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // crear usuario
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, apellido=:apellido, correo=:correo, contrasena=:contrasena, telefono=:telefono";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellido=htmlspecialchars(strip_tags($this->apellido));
        $this->correo=htmlspecialchars(strip_tags($this->correo));
        $this->contrasena=htmlspecialchars(strip_tags($this->contrasena));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
    
        // bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":contrasena", $this->contrasena);
        $stmt->bindParam(":telefono", $this->telefono);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // used when filling up the update usuario form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    u.id_u, u.nombre, u.apellido, u.correo, u.telefono
                FROM
                    " . $this->table_name . " u
                WHERE
                    u.id_u = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of usuario to be updated
        $stmt->bindParam(1, $this->id_u);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_u = $row['id_u'];
        $this->nombre = $row['nombre'];
        $this->apellido = $row['apellido'];
        $this->correo = $row['correo'];
        $this->telefono = $row['telefono'];
        $this->contrasena = null;
    }

    // update the usuario
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nombre = :nombre,
                    apellido = :apellido,
                    correo = :correo,
                    telefono = :telefono
                WHERE
                    id_u = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->id_u=htmlspecialchars(strip_tags($this->id_u));
        $this->apellido=htmlspecialchars(strip_tags($this->apellido));
        $this->correo=htmlspecialchars(strip_tags($this->correo));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
    
        // bind new values
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':id', $this->id_u);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":telefono", $this->telefono);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function updateRol(){
    
        // update query
        $query = "CALL update_user_rol(:id_u, :id_r)";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_r=htmlspecialchars(strip_tags($this->id_r));
        $this->id_u=htmlspecialchars(strip_tags($this->id_u));
    
        // bind new values
        $stmt->bindParam(':id_r', $this->id_r);
        $stmt->bindParam(':id_u', $this->id_u);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the usuario
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_u = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_u=htmlspecialchars(strip_tags($this->id_u));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id_u);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
?>