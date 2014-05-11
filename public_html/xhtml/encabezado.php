<?php

echo "\n<!-- encabezado -->\n";
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/iniciar.php');
$idiomas = @include_once($_SERVER['DOCUMENT_ROOT'].'/../cms2/datos/idiomas.php');
$sel_idioma = $_GET['leng'] ? $_GET['leng'] : $_COOKIE['leng'];
$sel_idioma = $idiomas[$sel_idioma] ? $sel_idioma : $poromision;

$secciones = @include($_SERVER['DOCUMENT_ROOT'].'/../cms2/datos/secciones.php');
$sel_seccion = trim($_SERVER['PATH_INFO'], "/");

function imprimir_secciones($secciones, &$nodo, $nivel = 0)
 {
  global $doc, $poromision;
  $lista = $doc->createElement('ul');
  $lista = $nodo->appendChild($lista);
  foreach($secciones AS $sec_k => $sec_v)
   {
	$li = $doc->createElement("li");
	$a = $doc->createElement("a");
	$a = $li->appendChild($a);
	$a->setAttribute("href", '/'.$sec_v['identificador']);
	$li = $lista->appendChild($li);
	$a->appendChild($doc->createTextNode($sec_v['nombre'][$poromision] ? $sec_v['nombre'][$poromision] : current($sec_v['nombre'])));
	if(count($sec_v['secciones']))
	 {
	    //$lista = $doc->createElement('ul');
	    //$lista = $li->appendChild($lista);
	    imprimir_secciones($sec_v['secciones'], $li, ++$nivel);
	    $nivel--;
	 }
   }
 }

//$s = new Validar($atributos, $leng);
$doc = new DOMDocument('1.0', 'utf-8');
$doc->formatOutput = true;
imprimir_secciones($secciones, $doc);

echo $doc->saveHTML();

echo "\n<!-- /encabezado -->\n";

?>