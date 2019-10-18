<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../model/categoria.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare categoria object
$categoria = new Categoria($db);
 
// set ID property of record to read
$categoria->id_c = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of categoria to be edited
$categoria->readOne();
 
if($categoria->nombre!=null){
    // create array
    $categoria_arr = array(
        "id_c" =>  $categoria->id_c,
        "nombre" => $categoria->nombre,
        "id_s" => $categoria->id_s
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($categoria_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user categoria does not exist
    echo json_encode(array("mensaje" => "La categoria no existe."));
}
?>