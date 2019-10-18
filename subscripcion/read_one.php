<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../model/subscripcion.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare subscripcion object
$subscripcion = new Subscripcion($db);
 
// set ID property of record to read
$subscripcion->id_s = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of subscripcion to be edited
$subscripcion->readOne();
 
if($subscripcion->nombre!=null){
    // create array
    $subscripcion_arr = array(
        "id_s" =>  $subscripcion->id_s,
        "nombre" => $subscripcion->nombre
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($subscripcion_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user subscripcion does not exist
    echo json_encode(array("mensaje" => "La subscripcion no existe."));
}
?>