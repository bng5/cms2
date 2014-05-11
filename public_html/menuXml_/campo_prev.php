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
  if($xml = @simplexml_load_file('../seccion/'.$id.'.xml.'.$idioma))
   {
	$dato = $xml->xpath("//dato[@id='".$campo."']");
	salida($dato[0][0]);
   }
  else
    salida("No se encontró la sección o el idioma.");
 }

function item($id, $campo, $idioma)
 {
/*
<br />
<b>Warning</b>:  simplexml_load_file() [<a href='function.simplexml-load-file'>function.simplexml-load-file</a>]: ../item/106.xml.ca:2: validity error : xml:id : attribute value 106 is not an NCName in <b>/home/eiseres/public_html/menuXml/campo.php</b> on line <b>21</b><br />
<br />
<b>Warning</b>:  simplexml_load_file() [<a href='function.simplexml-load-file'>function.simplexml-load-file</a>]: mlns:xml=&quot;http://www.w3.org/XML/1998/namespace&quot; xml:lang=&quot;ca&quot;&gt;&lt;item xml:id=&quot;106&quot; in <b>/home/eiseres/public_html/menuXml/campo.php</b> on line <b>21</b><br />
<br />
<b>Warning</b>:  simplexml_load_file() [<a href='function.simplexml-load-file'>function.simplexml-load-file</a>]:                                                                                ^ in <b>/home/eiseres/public_html/menuXml/campo.php</b> on line <b>21</b><br />
 */
  if($xml = @simplexml_load_file('../item/'.$id.'.xml.'.$idioma))
   {
    //$dato = $xml->xpath("//dato[@id='".$campo."']");
    $datos = $xml->xpath("//dato");
    foreach($datos AS $dato)
     {
	  $attr = $dato->attributes();
	  if($attr['id'] == $campo)
	   {
	    $txt = $dato[0];
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
  $db = BaseDatos::Conectar();
  if($id == 0)
   {
	$texto = include(RUTA_CARPETA.'cms2/datos/texto.todas.php');
    salida($texto[$idioma]);
   }
  $cons_seccion = $db->query("SELECT ads.identificador FROM `items_categorias` ic JOIN admin_secciones ads ON ic.seccion_id = ads.id WHERE ic.id = ".$id." LIMIT 1");
  if($fila = $cons_seccion->fetch_row())
   {
	$seccion = $fila[0];
	$campo = ($campo == '__categoria') ? 'titulo' : 'string__'.$campo;
	$cons_valor = $db->query("SELECT `".$campo."` FROM `pubcats__".$seccion."` WHERE id = ".$id." AND leng_cod = '".$idioma."'");
	if($valor = $cons_valor->fetch_row())
	  salida($valor[0]);
	salida("No se encontró el atributo.");
   }
 }

?>