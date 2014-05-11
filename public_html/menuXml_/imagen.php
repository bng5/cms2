<?php

require_once('../../inc/iniciar.php');

if($path = trim($_SERVER['PATH_INFO'], "/"))
 {
  $path_arr = explode("/", $path);
  //$campo = $path_arr[0];
  //$campo = $path_arr[0];
 }
else error("Debe especificar un campo");

$mysqli = BaseDatos::Conectar();


if(!$resultado = $mysqli->query("SELECT iv.atributo_id, io.archivo, io.peso, io.formato FROM `items_valores` iv JOIN items_atributos ia ON iv.atributo_id = ia.id, imagenes_orig io WHERE ia.identificador = '${path_arr[0]}' AND iv.`int` = io.id AND iv.item_id = {$path_arr[1]} LIMIT 1")) error(__LINE__.": Error en consulta.");
if($fila = $resultado->fetch_row())
 {
  header("Content-type: {$fila[3]}");
  header("Content-length: {$fila[2]}");
  readfile("../img/0/{$fila[0]}/{$fila[1]}");
  exit;
/*
	$id = array_shift($fila);
	$item = $doc->createElement("item");
	$item->setAttribute("xml:id", $id);
	$fila = array_slice($fila, 4);
	array_pop($fila);
	foreach($fila AS $k => $v)
	 {
	  if(empty($v)) continue;
	  $k = explode("__", $k);
	  if($k[0] == "int" || $k[0] == "num" || $k[0] == "date")
	   {
		$valores[$k[1]] = $v;
		continue;
	   }
	  elseif($k[0] == "img")
	   {
		$dato = $doc->createElement("imagen");
		$v = explode(",", $v);
		$dato->setAttribute("archivo", "img/0/{$v[0]}");
		$dato->setAttribute("mime", $v[1]);
		$dato->setAttribute("peso", $v[2]);
		$dato->setAttribute("ancho", $v[3]);
		$dato->setAttribute("alto", $v[4]);
		$dato->setAttribute("miniatura", "img/1/{$v[0]}");
		$dato->setAttribute("ancho_m", $v[5]);
		$dato->setAttribute("alto_m", $v[6]);
		$dato->setAttribute("peso_m", $v[7]);
	   }
	  elseif($k[0] == "arch")
	   {
		$dato = $doc->createElement("archivo");
		$v = explode(",", $v);
		$dato->setAttribute("archivo", "archivos/".$v[0]);
		$dato->setAttribute("mime", $v[1]);
		$dato->setAttribute("peso", $v[2]);
	   }
	  else
	   {
		$dato = $doc->createElement("dato");
		if($k[0] == "date" && !empty($v)) $v = formato_fecha($v, true, false);
		elseif($k[0] == "datetime" && !empty($v)) $v = formato_fecha($v, true);
		$dato->appendChild($doc->createTextNode(str_replace("\r", "", $v)));
		$dato->setAttribute("tipo", $tipos[$k[0]]);
		if($valores[$k[1]])
		 {
		  $dato->setAttribute("valor", $valores[$k[1]]);
		  unset($valores[$k[1]]);
		 }
	   }
	  $dato->setAttribute("id", $k[1]);
	  $dato = $item->appendChild($dato);
	 }
*/
 }


function error($error = "Ha ocurrido un error inesperado.")
 {
  header("Content-type: text/plain; charset=utf-8");
  echo $error;
  exit;
 }

?>