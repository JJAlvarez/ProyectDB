<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/rol.php';
 
// instantiate database and rol object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$rol = new Rol($db);

// query rols
$stmt = $rol->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // rols array
    $rols_arr=array();
    $rols_arr["roles"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $rol_item=array(
            "id_r" => $id_r,
            "nombre" => $nombre
        );
 
        array_push($rols_arr["roles"], $rol_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show rols data in json format
    echo json_encode($rols_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no rols found
    echo json_encode(
        array("mensaje" => "No se han encontrado los roles.")
    );
}

?>