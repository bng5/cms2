<?php

require_once('../../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');
//header('Content-type: text/plain; charset=utf-8');

$doc = new DOMDocument('1.0', 'utf-8');
$doc->formatOutput = true;
$root = $doc->createElement('atributos');

if($path = trim($_SERVER['PATH_INFO'], "/"))
 {
  $path_arr = explode("/", $path);
  $seccion = $path_arr[0];
  $seccion_id = Seccion::identificador_a_id($seccion);
  $leng = $path_arr[1] ? $path_arr[1] : "es";
  @include("../inc_xhtml/etiquetas_${seccion}.${leng}.php");
  $root->setAttribute("id", $seccion);

//print_r($campos);

//exit;
  $mysqli = BaseDatos::Conectar();
  if(!$resultado = $mysqli->query("SELECT * FROM `pub__${seccion_id}` LIMIT 1")) error("No existe ninguna publicación para la sección indicada.");
  if($finfo = $resultado->fetch_fields())
   {
	$campos = array();
	foreach ($finfo as $val)
	 {
	  $ex = explode("__", $val->name);
	  if($ex[1]) $campos[$ex[1]][$ex[0]] = true;
	 }
	$resultado->close();
	foreach($campos AS $k => $v)
	 {
	  $filtro = ($v['int'] || $v['string']) ? 1 : 0;
	  $max_min = ($v['int'] || $v['num'] || $v['date']) ? 1 : 0;
	  $salida = ($v['string'] || $v['img'] || $v['text'] || $v['arch']) ? 1 : 0;
	  $item = $doc->createElement("opcion");
	  $item->setAttribute("id", $k);
	  $item->setAttribute("filtro", $filtro);
	  $item->setAttribute("max_min", $max_min);
	  $item->setAttribute("salida", $salida);
	  if($etiquetas[$k]) $item->appendChild($doc->createTextNode($etiquetas[$k]));
	  $item = $root->appendChild($item);
	  //echo "<opcion id=\"${k}\" filtro=\"${filtro}\"></opcion>\n";
	 }
   }

 }

$root = $doc->appendChild($root);
echo $doc->saveXML();

function error($error = "Ha ocurrido un error inesperado.")
 {
  global $doc;
  //header("HTTP/1.0 404 Not Found");
  $root = $doc->createElement('error');
  $root->appendChild($doc->createTextNode($error));
  $root = $doc->appendChild($root);
  echo $doc->saveXML();
  exit;
 }

?>