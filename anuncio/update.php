<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../model/anuncio.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare anuncio object
$anuncio = new Anuncio($db);
 
// get id of anuncio to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of anuncio to be edited
$anuncio->id_anuncio = $data->id;
 
// set anuncio property values
$anuncio->nombre = $data->nombre;
$anuncio->link_imagen = $data->link_imagen;
 
// update the anuncio
if($anuncio->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "Anuncio actualizado exitosamente.", "updated" => true));
}
 
// if unable to update the anuncio, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Error al actualizar el anuncio.", "updated" => false));
}
?>