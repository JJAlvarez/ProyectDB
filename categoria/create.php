<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate categoria object
include_once '../model/categoria.php';
 
$database = new Database();
$db = $database->getConnection();
 
$categoria = new Categoria($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->nombre) && !empty($data->id_s)
){
 
    // set categoria property values
    $categoria->nombre = $data->nombre;
    $categoria->id_s = $data->id_s;
 
    // create the categoria
    if($categoria->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("mensaje" => "Categoria creada exitosamente.", "created" => true));
    }
 
    // if unable to create the categoria, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("mensaje" => "Error al crear la categoria.", "created" => false));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("mensaje" => "No se puede crear la categoria. Informacion incompleta.", "created" => false));
}
?>