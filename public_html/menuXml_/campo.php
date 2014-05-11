<?php

include('../../inc/iniciar.php');

if($path = explode("/", trim($_SERVER['PATH_INFO'], " /")))
 {
  list($tipo, $id, $campo, $idioma) = $path;
  if(function_exists($tipo))
    $tipo($id, $campo, $idioma);
  else
    salida("Debe indicar si se trata de un item, una sección o una categoría.\n/menuXml/campo/item...\n/menuXml/campo/seccion...\n/menuXml/campo/categoria...");
 }

function salida($txt)
 {
  header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");//text/plain; charset=UTF-8");
  exit('txt='.urlencode($txt));
 }

function seccion($id, $campo, $idioma)
 {
  //if($xml = simplexml_load_file('../seccion/'.$id.'.xml.'.$idioma))
  if($seccion = Modelo_Secciones::getPorIdentificador($id))
   {
	if($valores = include('../../cms2/datos/seccion/'.$seccion->getId().'.'.$idioma.'.php'))
	 {
	  $db = DB::Conectar();
	  $consulta = $db->query("SELECT i.id FROM `secciones_a_atributos` s JOIN items_atributos i ON s.atributo_id = i.id WHERE s.seccion_id = ".$seccion->getId()." AND i.identificador = '".$campo."' LIMIT 1");
	  salida($valores[$consulta->fetchColumn()]);
	 }
	else
      salida("No se encontró el idioma solicitado.");
   }
  else
    salida("No se encontró la sección.");
 }

function item($id, $campo, $idioma)
 {
  if($valores = include('../../cms2/datos/item/'.$id.'.'.$idioma.'.php'))
   {
	$db = DB::Conectar();
	$consulta = $db->query("SELECT ia.id FROM `items_secciones_a_atributos` isaa JOIN items_atributos ia ON isaa.atributo_id = ia.id WHERE isaa.seccion_id = ".$valores['seccion_id']." AND ia.identificador = '".$campo."' LIMIT 1");
	salida($valores['valores'][$consulta->fetchColumn()]);
   }
  else
    salida("No se encontró el item o idioma solicitado.");
 }

function categoria($id, $campo, $idioma)
 {
  $db = BaseDatos::Conectar();
  if($id == 0)
   {
	$texto = include(RUTA_CARPETA.'cms2/datos/texto.todas.php');
    salida($texto[$idioma]);
   }
  $cons_seccion = $db->query("SELECT ads.identificador FROM `items_categorias` ic JOIN secciones ads ON ic.seccion_id = ads.id WHERE ic.id = ".$id." LIMIT 1");
  if($fila = $cons_seccion->fetch_row())
   {
	$seccion = $fila[0];
	if($campo == '__categoria')
		$campo = 'titulo';
	else {
		if(!$cons_campos = $db->query("SELECT * FROM `pubcats__${seccion}` LIMIT 1"))
			error("No existe ninguna publicación para la categoría indicada.");
		if($finfo = $cons_campos->fetch_fields()) {
			foreach($finfo as $val) {
				$ex = explode("__", $val->name);
				if($ex[1] && $campo == $ex[1])
					$campo = "{$ex[0]}__{$ex[1]}";
			}
			$cons_campos->close();
		}
	}
	//$campo = ($campo == '__categoria') ? 'titulo' : 'string__'.$campo;
	$cons_valor = $db->query("SELECT `".$campo."` FROM `pubcats__".$seccion."` WHERE id = ".$id." AND leng_cod = '".$idioma."'");
	if($valor = $cons_valor->fetch_row())
	  salida($valor[0]);
	salida("No se encontró el atributo.");
   }
 }

?>