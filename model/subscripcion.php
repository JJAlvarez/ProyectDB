<?php

class Subscripcion {

    //conexion con la base de datos
    private $conn;
    private $table_name = "subscripcion";

    //propiedades
    public $id_s;
    public $nombre;

    //constructor con la conexion 
    public function __construct($db) {
        $this->conn = $db;
    }

    // leer subscripciones
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

    // crear subscripcion
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

    // used when filling up the update subscripcion form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " r
                WHERE
                    r.id_s = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of subscripcion to be updated
        $stmt->bindParam(1, $this->id_s);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->nombre = $row['nombre'];
    }

    // update the subscripcion
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nombre = :nombre
                WHERE
                    id_s = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->id_s=htmlspecialchars(strip_tags($this->id_s));
    
        // bind new values
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':id', $this->id_s);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the subscripcion
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_s = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_s=htmlspecialchars(strip_tags($this->id_s));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id_s);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
?>