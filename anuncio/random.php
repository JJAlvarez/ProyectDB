<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../model/anuncio.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare anuncio object
$anuncio = new Anuncio($db);
 
// read the details of anuncio to be edited
$anuncio->random();
 
if($anuncio->nombre!=null){
    // create array
    $anuncio_arr = array(
        "id_anuncio" =>  $anuncio->id_anuncio,
        "nombre" => $anuncio->nombre,
        "link_imagen" => $anuncio->link_imagen
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($anuncio_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user anuncio does not exist
    echo json_encode(array("mensaje" => "El anuncio no existe."));
}
?>