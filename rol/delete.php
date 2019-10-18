<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../model/rol.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare rol object
$rol = new Rol($db);
 
// get rol id
$data = json_decode(file_get_contents("php://input"));
 
// set rol id to be deleted
$rol->id_r = $data->id;
 
// delete the rol
if($rol->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "Rol eliminado.", "deleted" => true));
}
 
// if unable to delete the rol
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("mensaje" => "Error al eliminar el rol.", "deleted" => false));
}
?>