<?php

include('../inc/iniciar.php');
header("Content-Type: application/xml; charset=UTF-8");

preg_match('/(\w*)(.xml\.?(\w*))?/', trim($_SERVER['PATH_INFO'], "/ "), $coincidencias);
list($ruta, $identificador, $ext, $leng_cod) = $coincidencias;

//$idioma = Idiomas::getPorCodigo($leng_cod);
$idioma = Publicacion_Idiomas::resolver($leng_cod);
//$seccion = Seccion::crear_desde_identificador($identificador, $idioma->id);
$seccion = Publicacion_Secciones::resolver($identificador, $idioma);
$seccion_id = $seccion->id;

if(!$valores = @include("../cms2/datos/seccion/${seccion_id}.".$idioma->codigo.".php"))
 {
  header("Content-Type: text/plain; charset=UTF=8", true, 404);
  exit("\n");
 }

$mysqli = BaseDatos::Conectar();
$atributos = array();
$consulta = $mysqli->query("SELECT iat.id, iat.identificador, iat.sugerido, iat.unico, iat.tipo_id, iat.extra, saa.por_omision, ian.atributo FROM `secciones_a_atributos` saa LEFT JOIN items_atributos_n ian ON saa.atributo_id = ian.id AND ian.leng_id = ".$idioma->id.",  items_atributos iat  WHERE saa.`atributo_id` = iat.id AND `seccion_id` = ".$seccion_id." ORDER BY orden");
if($fila = $consulta->fetch_assoc())
 {
  do
   {
	$attr_id = array_shift($fila);
	$atributos[$attr_id] = $fila;
   }while($fila = $consulta->fetch_assoc());
 }
$consulta->close();

/*$valores = array();
$consulta = $mysqli->query("SELECT atributo_id, `string`, `date`, `text`, `int`, `num` FROM `secciones_valores` WHERE `item_id` = ".$seccion_id." AND (leng_id = ".$idioma->id." OR leng_id IS NULL)");
if($fila = $consulta->fetch_assoc())
 {
  do
   {
	$attr_id = array_shift($fila);
	$valores[$attr_id] = $fila;
   }while($fila = $consulta->fetch_assoc());
 }
var_dump($valores);
$consulta->close();
*/

$nodos = array(
  1 => array('nodo' => 'dato', 'tipo' => 'texto'),
  2 => array('nodo' => 'imagen'),
  3 => array('nodo' => 'archivo'),
  5 => array('nodo' => 'dato', 'tipo' => 'areadetexto'),
 //22 => array('nodo' => 'dato', 'tipo' => 'enlace'),
 );

$doc = new DOMDocument('1.0', 'utf-8');
//$doc->formatOutput = true;
//$doc->appendChild(new DOMProcessingInstruction('xsl-stylesheet', 'type="text/xsl" href="/xsl/items.xsl"'));

$root = $doc->createElement('xml');
$root = $doc->appendChild($root);

$attr = $doc->createAttributeNS("http://www.w3.org/XML/1998/namespace", "xml:lang");
$attr->value = $idioma->codigo;
$root->appendChild($attr);

$item = $doc->createElement('item');
$item = $root->appendChild($item);
$item->setAttribute('etiqueta', $seccion->nombres[$idioma->codigo]);

foreach($atributos AS $k => $v)
 {
  $atributo = $doc->createElement($nodos[$v['tipo_id']]['nodo']);
  $atributo->setAttribute('id', $v['identificador']);
  if($nodos[$v['tipo_id']]['tipo'])
    $atributo->setAttribute('tipo', $nodos[$v['tipo_id']]['tipo']);
  if($v['atributo'])
    $atributo->setAttribute('etiqueta', $v['atributo']);

  if($valor = $valores['valores'][$k])
   {
    switch($v['tipo_id']) {
	  case 2:
          $atributo->setAttribute('mime', $valor['mime']);
          $atributo->setAttribute('peso', $valor['peso']);
          $atributo->setAttribute('ancho', $valor['ancho']);
          $atributo->setAttribute('alto', $valor['alto']);
          $atributo->setAttribute('archivo', 'img/0/'.$k.'/'.$valor['archivo']);
          $atributo->setAttribute('miniatura', 'img/1/'.$k.'/'.$valor['miniatura']);
          $atributo->setAttribute('ancho_m', $valor['ancho_m']);
          $atributo->setAttribute('alto_m', $valor['alto_m']);
          $atributo->setAttribute('peso_m', $valor['peso_m']);
	  case 9:
		  $valor = $valor['int'];
		  break;
	  default:
		  $valor = $valor;
		  break;
     }
    $atributo->appendChild($doc->createTextNode(str_replace("\r", "", $valor)));
   }
  $item->appendChild($atributo);
 }

echo $doc->saveXML();

?>