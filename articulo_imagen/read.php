<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/imagen_articulo.php';
 
// instantiate database and imagen_articulo object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$imagen_articulo = new ImagenArticulo($db);

$imagen_articulo->id_a = isset($_GET['id_a']) ? $_GET['id_a'] : die();

// query rols
$stmt = $imagen_articulo->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // imagen_articulos array
    $imagen_articulos_arr=array();
    $imagen_articulos_arr["imagen_articulos"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $imagen_articulo_item=array(
            "id_a" =>  $id_a,
            "link" => $link,
            "id_i_a" => $id_i_a
        );
 
        array_push($imagen_articulos_arr["imagen_articulos"], $imagen_articulo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show imagen_articulos data in json format
    echo json_encode($imagen_articulos_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no imagen_articulos found
    echo json_encode(
        array("mensaje" => "No se han encontrado los imagen_articulos.")
    );
}

?>