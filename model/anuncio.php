<?php

class Anuncio {


    private $conn; 
    private $table_name = "anuncio";

    public $id_anuncio;
    public $nombre;
    public $link_imagen;

    public function __construct($db) {
        $this->conn = $db;
    }

    // leer anuncios
    function read(){
    
        // select all query
        $query = "SELECT *
         FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // leer anuncios
    function random(){
    
        // select all query
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY RAND() LIMIT 1";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->nombre = $row['nombre'];
        $this->id_anuncio = $row['id_anuncio'];
        $this->link_imagen = $row['link_imagen'];
    }

    // crear anuncio
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, link_imagen=:link_imagen";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
    
        // bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":link_imagen", $this->link_imagen);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // update the anuncio
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nombre = :nombre,
                    link_imagen = :link_imagen
                WHERE
                    id_anuncio = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->id_anuncio=htmlspecialchars(strip_tags($this->id_anuncio));
        $this->link_imagen=htmlspecialchars(strip_tags($this->link_imagen));
    
        // bind new values
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':id', $this->id_anuncio);
        $stmt->bindParam(':link_imagen', $this->link_imagen);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the anuncio
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_anuncio = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_anuncio=htmlspecialchars(strip_tags($this->id_anuncio));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id_anuncio);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
?>