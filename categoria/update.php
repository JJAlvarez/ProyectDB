<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../model/categoria.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare categoria object
$categoria = new Categoria($db);
 
// get id of categoria to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of categoria to be edited
$categoria->id_c = $data->id;
 
// set categoria property values
$categoria->nombre = $data->nombre;
$categoria->id_s = $data->id_s;
 
// update the categoria
if($categoria->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "Categoria actualizada exitosamente.", "updated" => true));
}
 
// if unable to update the categoria, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Error al actualizar la categoria.", "updated" => false));
}
?>