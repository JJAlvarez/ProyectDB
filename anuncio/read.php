<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/anuncio.php';
 
// instantiate database and anuncio object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$anuncio = new Anuncio($db);

// query rols
$stmt = $anuncio->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // anuncios array
    $anuncios_arr=array();
    $anuncios_arr["anuncios"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $anuncio_item=array(
            "id_anuncio" => $id_anuncio,
            "nombre" => $nombre,
            "link_imagen" => $link_imagen,
        );
 
        array_push($anuncios_arr["anuncios"], $anuncio_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show anuncios data in json format
    echo json_encode($anuncios_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no anuncios found
    echo json_encode(
        array("mensaje" => "No se han encontrado los anuncios.")
    );
}

?>