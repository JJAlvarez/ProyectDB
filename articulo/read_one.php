<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../model/articulo.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare articulo object
$articulo = new Articulo($db);
 
// set ID property of record to read
$articulo->id_a = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of articulo to be edited
$articulo->readOne();
 
if($articulo->nombre!=null){
    // create array
    $articulo_arr = array(
        "id_a" =>  $articulo->id_a,
        "fecha_p" => $articulo->fecha_p,
        "id_u" => $articulo->id_u,
        "plantilla" => $articulo->plantilla,
        "reads" => $articulo->reads,
        "status" => $articulo->status,
        "text" => $articulo->text,
        "titulo" => $articulo->titulo,
        "id_s_c" => $articulo->id_s_c
    ); 
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($articulo_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user articulo does not exist
    echo json_encode(array("mensaje" => "El articulo no existe."));
}
?>