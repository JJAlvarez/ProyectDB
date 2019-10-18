<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/categoria.php';
 
// instantiate database and categoria object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$categoria = new Categoria($db);

// query rols
$stmt = $categoria->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // categorias array
    $categorias_arr=array();
    $categorias_arr["categorias"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $categoria_item=array(
            "id_c" => $id_c,
            "nombre" => $nombre,
            "id_s" => $id_s,
            "nombre_subscripcion" => $nombre_subscripcion
        );
 
        array_push($categorias_arr["categorias"], $categoria_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show categorias data in json format
    echo json_encode($categorias_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no categorias found
    echo json_encode(
        array("mensaje" => "No se han encontrado las categorias.")
    );
}

?>