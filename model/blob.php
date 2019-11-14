<?php
class Blob {


    private $conn; 
    private $table_name = "blobs";

    public $id_blob;    
    public $nombre; 
    public $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

    public function __construct($db) {
        $this->conn = $db;
    }

    // leer imagen blob
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

    // crear imagen blob
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, imagen=:imagen";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));   

        // bind values        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":imagen", $this->imagen);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // update imagen blob
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET                    
                    imagen = :imagen
                WHERE
                    id_blob = :id_blob";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize        
        $this->id_blob=htmlspecialchars(strip_tags($this->id_blob));        
    
        // bind new values        
        $stmt->bindParam(':id', $this->id_blob);
        $stmt->bindParam(':imagen', $this->imagen);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete imagen blob
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_blob = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_blob=htmlspecialchars(strip_tags($this->id_blob));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id_blob);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
