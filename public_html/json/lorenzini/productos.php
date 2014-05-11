<?php

require('../../../inc/iniciar.php');
if(!$_SESSION['usuario_id'])
 {
  header("Content-Type: application/json; charset=UTF-8", true, 401);
  exit(' ');
 }

header("Content-Type: application/json; charset=UTF-8");
$leng_cod = $_GET['leng'];
$rpp = is_numeric($_GET['rpp']) ? (int) $_GET['rpp'] : 12;
$pagina = is_numeric($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$desde = ($pagina - 1) * $rpp;
//$recursivo = ($_GET['recursivo'] == '1');

$db = DB::instancia();
if($_GET['cat'][0])
 {
  $bsq_cat = 'AND ';
  if($_GET['cat'][1])
	$bsq_cat .= 'iac.categoria_id = '.(int) $_GET['cat'][1];
  else
    $bsq_cat .= 'ic.superior = '.$_GET['cat'][0];
 }
elseif(isset($_GET['codigo']))
 {
  $bsq_cat = "AND pc.`string__codigo` LIKE '%".addslashes($_GET['codigo'])."%'";
 }

$consulta_total = $db->query("SELECT COUNT(*) FROM `pub__catalogo` pc LEFT JOIN items_a_categorias iac ON pc.id = iac.item_id, items_categorias ic WHERE pc.leng_cod = '".$leng_cod."' AND iac.categoria_id = ic.id AND `string__preciopublico` IS NOT NULL ".$bsq_cat);
$respuesta->total = $consulta_total->fetchColumn();
$respuesta->pagina = $pagina;
$respuesta->paginas = ceil($respuesta->total / $rpp);
$respuesta->rpp = $rpp;

$consulta = $db->query("SELECT pc.id, pc.string__titulo AS titulo, pc.img__miniatura_prod AS img, pc.num__preciocoste AS precio, pc.string__preciopublico AS preciopublico, pc.string__codigo AS codigo, iac.categoria_id FROM `pub__catalogo` pc LEFT JOIN items_a_categorias iac ON pc.id = iac.item_id, items_categorias ic WHERE pc.leng_cod = '".$leng_cod."' AND iac.categoria_id = ic.id AND `string__preciopublico` IS NOT NULL ".$bsq_cat." ORDER BY pc.orden LIMIT ".$desde.", ".$rpp);
$consulta->setFetchMode(DB::FETCH_OBJ);
$respuesta->productos = array();
foreach($consulta AS $producto)
 {
  $producto->img = explode(",", $producto->img);
  $respuesta->productos[$producto->id] = $producto;
  $respuesta->productos[$producto->id]->precio = $producto->precio + 0;
 }

echo json_encode($respuesta);


?>