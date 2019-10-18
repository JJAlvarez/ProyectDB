<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../model/subscripcion.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare subscripcion object
$subscripcion = new Subscripcion($db);
 
// get subscripcion id
$data = json_decode(file_get_contents("php://input"));
 
// set subscripcion id to be deleted
$subscripcion->id_s = $data->id;
 
// delete the subscripcion
if($subscripcion->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "Subscripcion eliminada.", "deleted" => true));
}
 
// if unable to delete the subscripcion
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("mensaje" => "Error al eliminar la subscripcion.", "deleted" => false));
}
?>