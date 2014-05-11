<?php

require_once('../../inc/iniciar.php');
//header('Content-type: application/xml; charset=utf-8');
header('Content-type: application/xml; charset=utf-8');
$doc = new DOMDocument('1.0', 'utf-8');
//$doc->formatOutput = true;
//$doc->appendChild(new DOMProcessingInstruction('xsl-stylesheet', 'type="text/xsl" href="/xsl/items.xsl"'));

$root0 = $doc->createElement('xml');
$root0 = $doc->appendChild($root0);

if(!$idiomas = @include('../../cms2/datos/idiomas.php'))
 {
  error($error = "No fue posible recuperar los datos requeridos.");
  exit;
 }

$root = $doc->createElement('items');
$root = $root0->appendChild($root);

foreach($idiomas AS $sec_k => $sec_v)
 {
	$idioma = $doc->createElement("item");
	$idioma->setAttribute("xml:id", $sec_k);
	$idioma = $root->appendChild($idioma);
	foreach($sec_v AS $k => $v)
	 {
	  if($k == 'poromision')
	   {
	   	$idioma->setAttribute('poromision', "1");
	   	continue;
	   }
	  $dato = $doc->createElement('dato');
	  //$dato->setAttribute('type', gettype($v));
	  //if(is_bool($v)) $v = $v ? 'true' : 'false';
	  $dato->appendChild($doc->createTextNode($v));
	  $dato = $idioma->appendChild($dato);
	  $dato->setAttribute('id', $k);
	 }
 }

echo $doc->saveXML();

function error($error = "Ha ocurrido un error inesperado.")
 {
  global $doc, $root0;
  header("HTTP/1.1 500 Internal Server Error");
  $root = $doc->createElement('error');
  $root->appendChild($doc->createTextNode($error));
  $root = $root0->appendChild($root);
  echo $doc->saveXML();
  exit;
 }

?>