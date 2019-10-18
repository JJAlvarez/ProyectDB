<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate subcategoria object
include_once '../model/subcategoria.php';
 
$database = new Database();
$db = $database->getConnection();
 
$subcategoria = new SubCategoria($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->nombre) && !empty($data->id_c)
){
 
    // set subcategoria property values
    $subcategoria->nombre = $data->nombre;
    $subcategoria->id_c = $data->id_c;
 
    // create the subcategoria
    if($subcategoria->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("mensaje" => "SubCategoria creada exitosamente.", "created" => true));
    }
 
    // if unable to create the subcategoria, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("mensaje" => "Error al crear la SubCategoria.", "created" => false));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("mensaje" => "No se puede crear la SubCategoria. Informacion incompleta.", "created" => false));
}
?>