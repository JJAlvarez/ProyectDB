<?php

class ImagenArticulo {

    private $conn;
    private $table_name = "imagen_articulo";

    public $id_a;
    public $link;
    public $id_i_a;

    public function __construct($db) {
        $this->conn = $db;
    }

    // leer categorias
    function read(){
    
        // select all query
        $query = "SELECT * FROM imagen_articulo WHERE id_a = :id;";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id_a);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // crear categoria
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET link=:link, id_a=:id_a";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->link=htmlspecialchars(strip_tags($this->link));
        $this->id_a=htmlspecialchars(strip_tags($this->id_a));
    
        // bind values
        $stmt->bindParam(":link", $this->link);
        $stmt->bindParam(":id_a", $this->id_a);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // delete the categoria
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_a = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_a=htmlspecialchars(strip_tags($this->id_a));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id_a);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
?>