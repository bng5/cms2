<?php

include('../../inc/iniciar.php');

if($path = explode("/", trim($_SERVER['PATH_INFO'], " /")))
 {
  list($tipo, $id, $campo, $idioma) = $path;
  if(function_exists($tipo))
    $tipo($id, $campo, $idioma);
  else
    salida("Debe indicar si se trata de un item, una sección o una categoría.\n/menuXml/etiqueta/item...\n/menuXml/etiqueta/seccion...\n/menuXml/etiqueta/categoria...");
 }

function salida($txt)
 {
  header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");//text/plain; charset=UTF-8");
  exit('txt='.urlencode($txt));
 }

function seccion($id, $campo, $idioma)
 {
  if($xml = @simplexml_load_file('../seccion/'.$id.'.xml.'.$idioma))
   {
    $dato = $xml->xpath("//dato[@id='".$campo."']");
    $atributos = $dato[0]->attributes();
    salida($atributos['etiqueta']);
   }
  else
    salida("No se encontró la sección o el idioma.");
 }

function item($id, $campo, $idioma)
 {
  if($xml = @simplexml_load_file('../item/'.$id.'.xml.'.$idioma))
   {
    //$dato = $xml->xpath("//dato[@id='".$campo."']");
    $datos = $xml->xpath("item/*");
    foreach($datos AS $dato)
     {
	  $attr = $dato->attributes();
	  if($attr['id'] == $campo)
	   {
	    $txt = $attr['etiqueta'];
	    break;
	   }
     }
	if($txt)
      salida($txt);
	else
	  salida("No se encontró el atributo.");
   }
  else
    salida("No se encontró el item o el idioma.");
 }

function categoria($id, $campo, $idioma)
 {
  salida("No implementado.");
 }

?>