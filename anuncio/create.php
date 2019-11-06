<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate anuncio object
include_once '../model/anuncio.php';
 
$database = new Database();
$db = $database->getConnection();
 
$anuncio = new Anuncio($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->nombre) && !empty($data->link_imagen)
){
 
    // set anuncio property values
    $anuncio->nombre = $data->nombre;
    $anuncio->link_imagen = $data->link_imagen;
 
    // create the anuncio
    if($anuncio->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("mensaje" => "Anuncio creado exitosamente.", "created" => true));
    }
 
    // if unable to create the anuncio, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("mensaje" => "Error al crear la anuncio.", "created" => false));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("mensaje" => "No se puede crear el anuncio. Informacion incompleta.", "created" => false));
}
?>