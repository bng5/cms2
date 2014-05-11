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
  if($seccion = Modelo_Secciones::getPorIdentificador($id))
   {
	  $db = DB::Conectar();
	  $consulta = $db->query("SELECT ian.atributo FROM `secciones_a_atributos` s, items_atributos i JOIN items_atributos_n ian ON i.id = ian.id AND leng_id = (SELECT id FROM lenguajes WHERE codigo = '".$idioma."' LIMIT 1) WHERE s.atributo_id = i.id AND s.seccion_id = ".$seccion->getId()." AND i.identificador = '".$campo."' LIMIT 1");
	  salida($consulta->fetchColumn());
   }
  else
    salida("No se encontró la sección.");
 }

function item($id, $campo, $idioma)
 {
  if($valores = include('../../cms2/datos/item/'.$id.'.'.$idioma.'.php'))
   {
	$db = DB::Conectar();
	$consulta = $db->query("SELECT ian.atributo FROM `items_secciones_a_atributos` isaa, items_atributos ia JOIN items_atributos_n ian ON ia.id = ian.id AND leng_id = (SELECT id FROM lenguajes WHERE codigo = '".$idioma."' LIMIT 1) WHERE isaa.atributo_id = ia.id AND isaa.seccion_id = ".$valores['seccion_id']." AND ia.identificador = '".$campo."' LIMIT 1");
	salida($consulta->fetchColumn());
   }
  else
    salida("No se encontró el item o idioma solicitado.");
 }

function categoria($id, $campo, $idioma)
 {
  salida("No implementado.");
 }

?>