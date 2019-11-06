<?php

class Articulo {

    private $conn;
    private $table_name = "articulo";

    public $id_a;
    public $titulo;
    public $text;
    public $fecha_p;
    public $status;
    public $reads;
    public $header_image;
    public $id_u;
    public $id_s_c;
    public $plantilla;
    public $nombre_sub_categoria;
    public $nombre_autor;

    public function __construct($db) {
        $this->conn = $db;
    }

    // leer categorias
    function read(){
    
        // select all query
        $query = "SELECT * FROM articles_view;";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // leer categorias
    function readByUser(){
    
        // select all query
        $query = "SELECT * FROM articles_view WHERE id_u = :id;";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id_u);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // crear categoria
    function create(){
    
        // query to insert record
        $query = "call create_article(:id_s_c, 
            :id_u, :plantilla, :text, :titulo, :header_image, @id)";

        $query2 = "SELECT @id as id";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_s_c=htmlspecialchars(strip_tags($this->id_s_c));
        $this->id_u=htmlspecialchars(strip_tags($this->id_u));
        $this->plantilla=htmlspecialchars(strip_tags($this->plantilla));
        $this->text=htmlspecialchars(strip_tags($this->text));
        $this->titulo=htmlspecialchars(strip_tags($this->titulo));
        $this->header_image=htmlspecialchars(strip_tags($this->header_image));
    
        // bind values
        $stmt->bindParam(":id_s_c", $this->id_s_c);
        $stmt->bindParam(":id_u", $this->id_u);
        $stmt->bindParam(":plantilla", $this->plantilla);
        $stmt->bindParam(":text", $this->text);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":header_image", $this->header_image);
    
        // execute query
        if($stmt->execute()){
            $stmt = $this->conn->prepare($query2);
            if ($stmt->execute()) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id_a = $row['id'];
                return true;
            }
        }
    
        return false;
        
    }

    // used when filling up the update categoria form
    function readOne(){
    
        // query to read single record
        $query = "SELECT * FROM articles_view a 
        INNER JOIN usuario u ON u.id_u = a.id_u
        WHERE a.id_a = ? LIMIT 0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of categoria to be updated
        $stmt->bindParam(1, $this->id_a);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->fecha_p = $row['fecha_p'];
        $this->id_s_c = $row['id_s_c'];
        $this->id_u = $row['id_u'];
        $this->plantilla = $row['plantilla'];
        $this->reads = $row['reads'];
        $this->status = $row['status'];
        $this->text = $row['text'];
        $this->titulo = $row['titulo'];
        $this->id_c = $row['id_c'];
        $this->nombre_categoria = $row['nombre_categoria'];
        $this->header_image = $row['header_image'];
        $this->nombre_categoria = $row['nombre_categoria'];
        $this->nombre_sub_categoria = $row['nombre_sub_categoria'];
        $this->nombre_autor = $row['nombre'] . " " . $row['apellido']; 
    }

    // update the categoria
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                id_s_c=:id_s_c, plantilla=:plantilla, text=:text, titulo=:titulo
                WHERE
                    id_a = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id_s_c=htmlspecialchars(strip_tags($this->id_s_c));;
        $this->plantilla=htmlspecialchars(strip_tags($this->plantilla));
        $this->text=htmlspecialchars(strip_tags($this->text));
        $this->titulo=htmlspecialchars(strip_tags($this->titulo));
    
        // bind values
        $stmt->bindParam(":id", $this->id_a);
        $stmt->bindParam(":id_s_c", $this->id_s_c);
        $stmt->bindParam(":plantilla", $this->plantilla);
        $stmt->bindParam(":text", $this->text);
        $stmt->bindParam(":titulo", $this->titulo);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function updateBasic(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                id_s_c=:id_s_c, plantilla=:plantilla
                WHERE
                    id_a = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // bind values
        $stmt->bindParam(":id", $this->id_a);
        $stmt->bindParam(":id_s_c", $this->id_s_c);
        $stmt->bindParam(":plantilla", $this->plantilla);
    
        // execute the query
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