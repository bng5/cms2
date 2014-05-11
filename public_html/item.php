<?php

require('../inc/iniciar.php');
$mysqli = BaseDatos::Conectar();

preg_match('/(\w*)(.xml\.?(\w*))?/', trim($_SERVER['PATH_INFO'], "/ "), $coincidencias);
list($ruta, $item_id, $ext, $leng_cod) = $coincidencias;

//header("Content-Type: text/plain; charset=UTF=8");
$leng_id = Idiomas::id_desde_codigo($leng_cod);

if(!$item = include("../cms2/datos/item/{$item_id}.{$leng_cod}.php")) {
  header("Content-Type: text/plain; charset=UTF=8", true, 404);
  exit("\n");
}

//header('Last-Modified: '.date("r", $item['modificado']));


//print_r($item);

$funciones = array(
  Atributo::TEXTO_LINEA => array('func' => 'bloque_1', 'params' => array('nodo' => 'dato', 'tipo' => 'texto')),
  Atributo::TEXTO_LINEA_NO_LENG => array('func' => 'bloque_1', 'params' => array('nodo' => 'dato', 'tipo' => 'texto')),
  Atributo::COLOR => array('func' => 'bloque_1', 'params' => array('nodo' => 'dato', 'tipo' => 'hex')),
  Atributo::FECHA_HORA => array('func' => 'bloque_1', 'params' => array('nodo' => 'dato', 'tipo' => 'fecha')),
  Atributo::TEXTO => array('func' => 'bloque_1', 'params' => array('nodo' => 'dato', 'tipo' => 'areadetexto')),
  Atributo::PRECIO => array('func' => 'bloque_1', 'params' => array('nodo' => 'precio')),

  Atributo::IMAGEN => array('func' => 'imagen', 'params' => array()),
  Atributo::ARCHIVO => array('func' => 'archivo', 'params' => array()),

  Atributo::GALERIA_IMGS => array('func' => 'galeria', 'params' => array()),
  Atributo::AREA => array('func' => 'area', 'params' => array()),
 );
 
function bloque_1(&$doc, $atributo, $valor, $params) {
    $nodo = $doc->createElement($params['nodo']);
    $nodo->appendChild($doc->createTextNode(str_replace("\r", "", $valor)));
    $nodo->setAttribute("tipo", $params['tipo']);
    return $nodo;
}

function bloque_2(&$doc, $atributo, $valor, $params) {
    $nodo = $doc->createElement($params['nodo']);
    foreach($valor AS $k => $v) {
        $nodo->setAttribute($k, $v);
    }
    return $nodo;
}

function bloque_3(&$doc, $atributo, $valor, $params) {

}



function imagen(&$doc, $atributo, $valor, $params) {
    $valor['archivo'] = 'img/0/'.$atributo->id.'/'.$valor['archivo'];
    $valor['miniatura'] = 'img/1/'.$atributo->id.'/'.$valor['miniatura'];
    $params['nodo'] = 'imagen';
    return bloque_2(&$doc, $atributo, $valor, $params);
 }

function archivo(&$doc, $atributo, $valor, $params) {
//<archivo archivo="archivos/sonido_de_prueba_2.mp3" mime="application/force-download" peso="244956" id="sonido"/>
//    [archivo] => sonido_de_prueba_2.mp3

  $valor['archivo'] = 'archivos/'.$valor['archivo'];//'.$atributo->id.'/
  $params['nodo'] = 'archivo';
  return bloque_2(&$doc, $atributo, $valor, $params);
 }
/*
function texto(&$doc, $atributo_id)
 {
  global $item;
  $nodo = $doc->createElement('dato', $item['valores'][$atributo_id]);
  $nodo->setAttribute("tipo", "texto");
  return $nodo;
 }

function areadetexto(&$doc, $atributo_id)
 {
  global $item;
  $nodo = $doc->createElement('dato', $item['valores'][$atributo_id]);
  $nodo->setAttribute("tipo", "areadetexto");
  return $nodo;
 }
*/


define("XMLNS", "http://www.w3.org/XML/1998/namespace");
header('Content-type: application/xml; charset=utf-8');
$doc = new DOMDocument('1.0', 'UTF-8');
$doc->formatOutput = true;
$root = $doc->appendChild($doc->createElement('xml'));
$attr_lang = $doc->createAttributeNS(XMLNS, "xml:lang");
$attr_lang->value = $leng_cod;
$root->appendChild($attr_lang);
$nodo[0] = $root->appendChild($doc->createElement('item'));
$attr_id = $doc->createAttributeNS(XMLNS, "xml:id");
$attr_id->value = $item_id;
$nodo[0]->appendChild($attr_id);
$nodo[0]->setAttribute("seccion", $item['seccion']);
$nodo[0]->setAttribute("creado", $item['creado']);
$nodo[0]->setAttribute("modificado", $item['modificado']);

//$nodo_prev = 0;
//if($atributos = Listado::Atributos($leng_id, array('items' => $item['seccion_id'])))


if($atributos = Atributos::Listado($leng_id, array('items' => $item['seccion_id']))) {
  $atributosIt = $atributos->getIterator();
  foreach($atributosIt AS $v) {
	$k = $v->id;
    //if(!$item['valores'][$k])
    //  continue;
	$funcion = $funciones[$v->tipo]['func'];//'bloque_'.Atributo::$tipos[$v->tipo]['bloque'];
//if(function_exists($funcion))
// {
    $nodo[$k] = $nodo[$v->superior]->appendChild($funcion($doc, $v, $item['valores'][$k], $funciones[$v->tipo]['params']));
    $nodo[$k]->setAttribute("id", $v->identificador);
    $nodo[$k]->setAttribute("etiqueta", $v->nombre);
// }
//	$nodo_prev = $k;
   }
 }
echo $doc->saveXML();

?>