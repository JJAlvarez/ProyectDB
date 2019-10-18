<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/subscripcion.php';
 
// instantiate database and subscripcion object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$subscripcion = new Subscripcion($db);

// query subscripcions
$stmt = $subscripcion->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // subscripcions array
    $subscripcions_arr=array();
    $subscripcions_arr["subscripciones"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $subscripcion_item=array(
            "id_s" => $id_s,
            "nombre" => $nombre
        );
 
        array_push($subscripcions_arr["subscripciones"], $subscripcion_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show subscripcions data in json format
    echo json_encode($subscripcions_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no subscripcions found
    echo json_encode(
        array("mensaje" => "No se han encontrado las subscripciones.")
    );
}

?>