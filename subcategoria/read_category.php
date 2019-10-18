<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/subcategoria.php';
 
// instantiate database and subcategoria object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$subcategoria = new SubCategoria($db);

$subcategoria->id_c = isset($_GET['id_c']) ? $_GET['id_c'] : die();

// query rols
$stmt = $subcategoria->readByCategory();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // subcategorias array
    $subcategorias_arr=array();
    $subcategorias_arr["subcategorias"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $subcategoria_item=array(
            "id_s_c" => $id_s_c,
            "nombre" => $nombre,
            "id_c" => $id_c,
            "nombre_categoria" => $nombre_categoria
        );
 
        array_push($subcategorias_arr["subcategorias"], $subcategoria_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show subcategorias data in json format
    echo json_encode($subcategorias_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no subcategorias found
    echo json_encode(
        array("mensaje" => "No se han encontrado las subcategorias.")
    );
}

?>