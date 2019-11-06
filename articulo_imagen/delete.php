<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../model/imagen_articulo.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare imagen_articulo object
$imagen_articulo = new ImagenArticulo($db);
 
// get imagen_articulo id
$data = json_decode(file_get_contents("php://input"));
 
// set imagen_articulo id to be deleted
$imagen_articulo->id_a = $data->id;
 
// delete the imagen_articulo
if($imagen_articulo->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("mensaje" => "imagen_articulo eliminado.", "deleted" => true));
}
 
// if unable to delete the imagen_articulo
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("mensaje" => "Error al eliminar el imagen_articulo.", "deleted" => false));
}
?>