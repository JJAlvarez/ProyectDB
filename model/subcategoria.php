<?php

class SubCategoria {

    private $conn;
    private $table_name = "subcategoria";

    public $id_sub_c;
    public $nombre;
    public $id_c;

    public function __construct($db) {
        $this->conn = $db;
    }

    // leer subcategorias
    function read(){
    
        // select all query
        $query = "SELECT s.id_s_c AS id_s_c,
        s.nombre AS nombre,
        s.id_c AS id_c,
        c.nombre AS nombre_categoria
        FROM subcategoria AS s INNER JOIN categoria AS c ON c.id_c = s.id_c";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // leer subcategorias
    function readByCategory(){
    
        // select all query
        $query = "SELECT s.id_s_c AS id_s_c,
        s.nombre AS nombre,
        s.id_c AS id_c,
        c.nombre AS nombre_categoria
        FROM subcategoria AS s INNER JOIN categoria AS c ON c.id_c = s.id_c WHERE c.id_c = :id_c";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_c", $this->id_c);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // crear subcategoria
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, id_c=:id_c";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->id_c=htmlspecialchars(strip_tags($this->id_c));
    
        // bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":id_c", $this->id_c);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // used when filling up the update subcategoria form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " sub
                WHERE
                    sub.id_sub_c = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of subcategoria to be updated
        $stmt->bindParam(1, $this->id_sub_c);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->nombre = $row['nombre'];
        $this->id_c = $row['id_c'];
    }

    // update the subcategoria
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nombre = :nombre
                WHERE
                    id_s_c = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->id_sub_c=htmlspecialchars(strip_tags($this->id_sub_c));
    
        // bind new values
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':id', $this->id_sub_c);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the subcategoria
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_s_c = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_sub_c=htmlspecialchars(strip_tags($this->id_sub_c));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id_sub_c);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    
}
?>