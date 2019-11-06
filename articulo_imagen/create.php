<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate imagen_articulo object
include_once '../model/imagen_articulo.php';
 
$database = new Database();
$db = $database->getConnection();
 
$imagen_articulo = new ImagenArticulo($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->link) && !empty($data->id_a)
){
 
    // set imagen_articulo property values
    $imagen_articulo->link = $data->link;
    $imagen_articulo->id_a = $data->id_a;
 
    // create the imagen_articulo
    if($imagen_articulo->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("mensaje" => "ImagenArticulo creado exitosamente.", "created" => true));
    }
 
    // if unable to create the imagen_articulo, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("mensaje" => "Error al crear el imagen_articulo.", "created" => false));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("mensaje" => "No se puede crear el imagen_articulo. Informacion incompleta.", "created" => false));
}
?>