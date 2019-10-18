<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../model/rol.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare rol object
$rol = new Rol($db);
 
// set ID property of record to read
$rol->id_r = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of rol to be edited
$rol->readOne();
 
if($rol->nombre!=null){
    // create array
    $rol_arr = array(
        "id_r" =>  $rol->id_r,
        "nombre" => $rol->nombre
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($rol_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user rol does not exist
    echo json_encode(array("mensaje" => "El rol no existe."));
}
?>