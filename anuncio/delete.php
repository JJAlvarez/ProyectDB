<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../model/anuncio.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare anuncio object
$anuncio = new Anuncio($db);
 
// get anuncio id
$data = json_decode(file_get_contents("php://input"));
 
// set anuncio id to be deleted
$anuncio->id_anuncio = $data->id;
 
// delete the anuncio
if($anuncio->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "anuncio eliminado.", "deleted" => true));
}
 
// if unable to delete the anuncio
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("mensaje" => "Error al eliminar el anuncio.", "deleted" => false));
}
?>