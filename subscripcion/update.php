<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../model/subscripcion.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare subscripcion object
$subscripcion = new Subscripcion($db);
 
// get id of subscripcion to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of subscripcion to be edited
$subscripcion->id_s = $data->id;
 
// set subscripcion property values
$subscripcion->nombre = $data->nombre;
 
// update the subscripcion
if($subscripcion->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "Subscripcion actualizada exitosamente.", "updated" => true));
}
 
// if unable to update the subscripcion, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Error al actualizar la subscripcion.", "updated" => false));
}
?>