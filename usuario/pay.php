<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate subscripcion object
include_once '../model/usuario.php';
 
$database = new Database();
$db = $database->getConnection();
 
$usuario = new Usuario($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->id_u)
){
 
    // set subscripcion property values
    $usuario->id_u = $data->id_u;
 
    // create the subscripcion
    if($usuario->pay()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("mensaje" => "subscripcion creada exitosamente.", "created" => true));
    }
 
    // if unable to create the subscripcion, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("mensaje" => "Error al crear la subscripcion.", "created" => false));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("mensaje" => "No se puede crear la subscripcion. Informacion incompleta.", "created" => false));
}
?>