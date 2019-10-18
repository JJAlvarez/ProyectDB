<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../model/usuario.php';
 
// instantiate database and usuario object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$usuario = new Usuario($db);

// query rols
$stmt = $usuario->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // usuarios array
    $usuarios_arr=array();
    $usuarios_arr["usuarios"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $usuario_item=array(
            "id_u" => $id_u,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "correo" => $correo,
            "telefono" => $telefono,
            "id_r" => $id_r,
            "nombre_rol" => $nombre_rol,
        );
 
        array_push($usuarios_arr["usuarios"], $usuario_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show usuarios data in json format
    echo json_encode($usuarios_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no usuarios found
    echo json_encode(
        array("mensaje" => "No se han encontrado las usuarios.")
    );
}

?>