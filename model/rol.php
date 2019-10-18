<?php

class Rol {

    //conexion con la base de datos
    private $conn;
    private $table_name = "rol";

    //propiedades
    public $id_r;
    public $nombre;

    //constructor con la conexion 
    public function __construct($db) {
        $this->conn = $db;
    }

    // leer roles
    function read(){
    
        // select all query
        $query = "SELECT
            *
        FROM
            " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // crear rol
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
    
        // bind values
        $stmt->bindParam(":nombre", $this->nombre);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // used when filling up the update rol form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " r
                WHERE
                    r.id_r = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of rol to be updated
        $stmt->bindParam(1, $this->id_r);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->nombre = $row['nombre'];
    }

    // update the rol
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nombre = :nombre
                WHERE
                    id_r = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->id_r=htmlspecialchars(strip_tags($this->id_r));
    
        // bind new values
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':id', $this->id_r);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the rol
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_r = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_r=htmlspecialchars(strip_tags($this->id_r));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id_r);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
?>