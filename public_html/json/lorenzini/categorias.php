<?php

require('../../../inc/iniciar.php');
if(!$_SESSION['usuario_id'])
 {
  header("Content-Type: application/json; charset=UTF-8", true, 401);
  exit(' ');
 }

$leng_cod = $_GET['leng'];

$db = DB::instancia();
$categorias_consulta = $db->query("SELECT id, superior, orden, titulo FROM pubcats__catalogo WHERE leng_cod = '".$leng_cod."' ORDER BY orden");
$categorias_consulta->setFetchMode(DB::FETCH_OBJ);
$categorias = array();
foreach($categorias_consulta AS $categoria)
 {
  $categorias[(int) $categoria->id] = $categoria;
 }


header("Content-Type: text/javascript; charset=UTF-8");
//header("Content-Type: application/json; charset=UTF-8");
//echo json_encode($categorias);
//echo "var Categorias = ".json_encode($categorias_consulta->fetchAll()).";";
echo "var Categorias = ".json_encode($categorias).";";


?>