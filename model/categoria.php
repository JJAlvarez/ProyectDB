<?php

class Categoria {


    private $conn; 
    private $table_name = "categoria";

    public $id_c;
    public $nombre;
    public $id_s;
    public $nombre_subscripcion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // leer categorias
    function read(){
    
        // select all query
        $query = "SELECT 
        c.id_c AS id_c,
        c.nombre AS nombre,
        c.id_s AS id_s,
        s.nombre AS nombre_subscripcion
         FROM " . $this->table_name . " c INNER JOIN subscripcion s ON s.id_s = c.id_s";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // crear categoria
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, id_s=:id_s";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
    
        // bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":id_s", $this->id_s);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // used when filling up the update categoria form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " c
                WHERE
                    c.id_c = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of categoria to be updated
        $stmt->bindParam(1, $this->id_c);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->nombre = $row['nombre'];
        $this->id_s = $row['id_s'];
    }

    // update the categoria
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nombre = :nombre,
                    id_s = :id_s
                WHERE
                    id_c = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->id_c=htmlspecialchars(strip_tags($this->id_c));
        $this->id_s=htmlspecialchars(strip_tags($this->id_s));
    
        // bind new values
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':id', $this->id_c);
        $stmt->bindParam(':id_s', $this->id_s);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the categoria
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_c = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_c=htmlspecialchars(strip_tags($this->id_c));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id_c);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
?>