<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate articulo object
include_once '../model/articulo.php';
 
$database = new Database();
$db = $database->getConnection();
 
$articulo = new Articulo($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->id_s_c) && !empty($data->id_u) && !empty($data->plantilla) && !empty($data->text) && !empty($data->titulo)
){
 
    // set articulo property values
    $articulo->id_s_c = $data->id_s_c;
    $articulo->id_u = $data->id_u;
    $articulo->plantilla = $data->plantilla;
    $articulo->text = $data->text;
    $articulo->titulo = $data->titulo;
 
    // create the articulo
    if($articulo->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("mensaje" => "Articulo creado exitosamente.", "created" => true));
    }
 
    // if unable to create the articulo, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("mensaje" => "Error al crear el articulo.", "created" => false));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("mensaje" => "No se puede crear el articulo. Informacion incompleta.", "created" => false));
}
?>