<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/articulo.php';
 
// instantiate database and articulo object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$articulo = new Articulo($db);

// query rols
$stmt = $articulo->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // articulos array
    $articulos_arr=array();
    $articulos_arr["articulos"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $articulo_item=array(
            "id_a" =>  $id_a,
            "fecha_p" => $fecha_p,
            "id_u" => $id_u,
            "plantilla" => $plantilla,
            "reads" => $reads,
            "status" => $status,
            "text" => $text,
            "titulo" => $titulo,
            "id_s_c" => $id_s_c
        );
 
        array_push($articulos_arr["articulos"], $articulo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show articulos data in json format
    echo json_encode($articulos_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no articulos found
    echo json_encode(
        array("mensaje" => "No se han encontrado los articulos.")
    );
}

?>