<?php

include('../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');
$doc = new DOMDocument('1.0', 'utf-8');
//$doc->formatOutput = true;
//$doc->appendChild(new DOMProcessingInstruction('xsl-stylesheet', 'type="text/xsl" href="/xsl/items.xsl"'));
$xml = $doc->appendChild($doc->createElement('xml'));
$xml->setAttribute('xml:lang', 'es');

preg_match('/(\w*)(.xml\.?(\w*))?/', trim($_SERVER['PATH_INFO'], "/ "), $coincidencias);
//preg_match('/(\d*)(.xml\.?(\w*))?/', $_SERVER['PATH_INFO'], $coincidencias);
list($ruta, $item, $ext, $leng_cod) = $coincidencias;

$seccion = 'locaciones';
$leng_cod = 'es';
$leng_id = 1;

$mysqli = BaseDatos::Conectar();
if(!$resultado = $mysqli->query("SELECT * FROM `pub__${seccion}` WHERE id = '".$item."' AND leng_cod = '".$leng_cod."' LIMIT 1")) error("No existe ninguna publicación para el item indicado.");
if($finfo = $resultado->fetch_fields())
 {
  $campos = array();
  foreach ($finfo as $val)
   {
	$ex = explode("__", $val->name);
	if($ex[1])
	  $campos[$ex[1]][$ex[0]] = "{$ex[0]}__{$ex[1]}";
   }
  if($fila = $resultado->fetch_assoc())
   {
	include('./inc_xhtml/etiquetas_locaciones.es.php');
	$tipos = array('string' => 'texto', 'num' => 'texto', 'text' => 'areadetexto', 'int' => 'entero', 'link' => 'enlace');
	$id = array_shift($fila);
	$item = $xml->appendChild($doc->createElement("item"));
	$item->setAttribute("xml:id", $id);
	$fila = array_slice($fila, 4);
	array_pop($fila);
	foreach($fila AS $k => $v)
	 {
	  if(empty($v))
	    continue;
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
		$attr = explode("/", $v[0], 2);
		array_unshift($v, $attr[0]);
		$dato->setAttribute("archivo", "img/0/{$v[1]}");
		$dato->setAttribute("mime", $v[2]);
		$dato->setAttribute("peso", $v[3]);
		$dato->setAttribute("ancho", $v[4]);
		$dato->setAttribute("alto", $v[5]);
		$dato->setAttribute("miniatura", "img/1/{$v[0]}/{$v[1]}");
		$dato->setAttribute("ancho_m", $v[6]);
		$dato->setAttribute("alto_m", $v[7]);
		$dato->setAttribute("peso_m", $v[8]);
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
		if($k[0] == "date" && !empty($v))
		  $v = formato_fecha($v, true, false);
		elseif($k[0] == "datetime" && !empty($v))
		  $v = formato_fecha($v, true);
		$dato->appendChild($doc->createTextNode(str_replace("\r", "", $v)));
		$dato->setAttribute("tipo", $tipos[$k[0]]);
		if($valores[$k[1]])
		 {
		  $dato->setAttribute("valor", $valores[$k[1]]);
		  unset($valores[$k[1]]);
		 }
	   }
	  $dato->setAttribute("id", $k[1]);
	  $dato->setAttribute("etiqueta", $etiquetas[$k[1]]);
	  $dato = $item->appendChild($dato);
	 }
	$resultado->close();
   }
 }
//$root = $xml->appendChild($root);
exit($doc->saveXML());


function error($desc = "Ha ocurrido un error inesperado.", $cod = false)
 {
  global $doc;
  $xml = $doc->appendChild($doc->createElement('xml'));
  header("HTTP/1.1 500 Internal Server Error");
  $root = $xml->appendChild($doc->createElement('error'));
  if($cod)
    $root->appendChild($doc->createElement('codigo', $cod));
  $root->appendChild($doc->createElement('descripcion', $desc));
  exit($doc->saveXML());
 }

?>