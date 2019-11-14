<?php

$connect = new PDO("mysql:host=localhost;dbname=revista", "root", "");

$form_data = json_decode(file_get_contents("php://input"));

$query = '';
$data = array();

if(isset($form_data->search_query))
{
 $search_query = $form_data->search_query;
 $query = "

 SELECT * FROM articles_view
 WHERE (id_u LIKE '%$search_query%'
 OR nombre_categoria LIKE '%$search_query%'
 OR fecha_p LIKE '%$search_query%'
 OR text LIKE ''%$search_query%')
 ";
}
else
{
 $query = "SELECT * FROM articles_view ORDER BY id_u ASC";
}

$statement = $connect->prepare($query);

if($statement->execute())
{
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }
 echo json_encode($data);
}
?>







