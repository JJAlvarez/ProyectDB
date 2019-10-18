<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../model/usuario.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare usuario object
$usuario = new Usuario($db);
 
$data = json_decode(file_get_contents("php://input"));

$usuario->correo = $data->correo;
$usuario->contrasena = $data->contrasena;
 
// read the details of usuario to be edited
$usuario->login();
 
if($usuario->nombre!=null){
    // create array
    $usuario_arr = array(
        "id_u" =>  $usuario->id_u,
        "nombre" => $usuario->nombre,
        "apellido" => $usuario->apellido,
        "correo" => $usuario->correo,
        "telefono" => $usuario->telefono,
        "id_r" => $usuario->id_r,
        "login" => true
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($usuario_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(200);
 
    // tell the user usuario does not exist
    echo json_encode(array("mensaje" => "Credenciales inválidas.", "login" => false));
}
?>