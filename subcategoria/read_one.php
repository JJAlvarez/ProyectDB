<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../model/subcategoria.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare subcategoria object
$subcategoria = new SubCategoria($db);
 
// set ID property of record to read
$subcategoria->id_r = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of subcategoria to be edited
$subcategoria->readOne();
 
if($subcategoria->nombre!=null){
    // create array
    $subcategoria_arr = array(
        "id_sub_c" =>  $subcategoria->id_sub_c,
        "nombre" => $subcategoria->nombre,
        "id_c" => $subcategoria->id_c
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($subcategoria_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user subcategoria does not exist
    echo json_encode(array("mensaje" => "La subcategoria no existe."));
}
?>