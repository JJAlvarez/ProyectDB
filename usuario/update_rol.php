<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../model/usuario.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare usuario object
$usuario = new Usuario($db);
 
// get id of usuario to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of usuario to be edited
$usuario->id_u = $data->id_u;
 
// set usuario property values
$usuario->id_r = $data->id_r;
 
// update the usuario
if($usuario->updateRol()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "Usuario actualizado exitosamente.", "updated" => true));
}
 
// if unable to update the usuario, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Error al actualizar el usuario.", "updated" => false));
}
?>