<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../model/usuario.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare usuario object
$usuario = new Usuario($db);
 
// get usuario id
$data = json_decode(file_get_contents("php://input"));
 
// set usuario id to be deleted
$usuario->id_u = $data->id;
 
// delete the usuario
if($usuario->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "Usuario eliminado.", "deleted" => true));
}
 
// if unable to delete the usuario
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("mensaje" => "Error al eliminar el usuario.", "deleted" => false));
}
?>