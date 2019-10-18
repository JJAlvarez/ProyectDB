<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../model/articulo.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare articulo object
$articulo = new Articulo($db);
 
// get id of articulo to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of articulo to be edited
$articulo->id_a = $data->id;
 
// set articulo property values
$articulo->id_s_c = $data->id_s_c;
$articulo->plantilla = $data->plantilla;
$articulo->text = $data->text;
$articulo->titulo = $data->titulo;
 
// update the articulo
if($articulo->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "Categoria actualizada exitosamente.", "updated" => true));
}
 
// if unable to update the articulo, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Error al actualizar la articulo.", "updated" => false));
}
?>