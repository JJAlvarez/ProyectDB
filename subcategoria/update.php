<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../model/subcategoria.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare subcategoria object
$subcategoria = new SubCategoria($db);
 
// get id of subcategoria to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of subcategoria to be edited
$subcategoria->id_sub_c = $data->id;
 
// set subcategoria property values
$subcategoria->nombre = $data->nombre;
$subcategoria->id_c = $data->id_c;
 
// update the subcategoria
if($subcategoria->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "subcategoria actualizada exitosamente.", "updated" => true));
}
 
// if unable to update the subcategoria, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Error al actualizar la subcategoria.", "updated" => false));
}
?>