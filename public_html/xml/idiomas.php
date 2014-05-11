<?php

require_once('../../inc/iniciar.php');
header('Content-Type: application/xml; charset=utf-8');
$doc = new DOMDocument('1.0', 'utf-8');
$doc->formatOutput = true;

if($_GET['modo'] == 'xsl')
  $doc->appendChild(new DOMProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="/xml/xsl/idiomas.xsl"'));
elseif($_GET['modo'] == 'css')
  $doc->appendChild(new DOMProcessingInstruction('xml-stylesheet', 'type="text/css" href="/css/xml.css"'));
else
  unset($_GET['modo']);
$q = array();
if($_GET['modo'])
  $q[] = "modo=".$_GET['modo'];
//$root0 = $doc->createElement('xml');
//$root0 = $doc->appendChild($root0);

$respuesta = $doc->createElement('respuesta');
//$respuesta = $root0->appendChild($respuesta);
//$peticion = $doc->createElement('peticion');
//$peticion = $cabeceras->appendChild($peticion);

//$ruta = $doc->createElement('ruta');
//$ruta->appendChild($doc->createTextNode('/xml/idiomas'));
//$ruta = $peticion->appendChild($ruta);
//$consulta = $doc->createElement('consulta');
//$consulta = $peticion->appendChild($consulta);
/*
foreach($_GET AS $get_k => $get_v)
  {
   if(is_array($get_v))
    {
     foreach($get_v AS $get_kk => $get_vv)
      {
	   $get = $doc->createElement($get_k);
	   $get->appendChild($doc->createTextNode($get_vv));
	   $consulta->appendChild($get);
	  }
	 continue;
	}
   $get = $doc->createElement($get_k);
   $get->appendChild($doc->createTextNode($get_v));
   $consulta->appendChild($get);
  }
*/
//$respuesta = $doc->createElement('respuesta');
//$respuesta = $cabeceras->appendChild($respuesta);
$sitio = $doc->createElement('sitio');
$sitio->appendChild($doc->createTextNode(SITIO_TITULO));
$sitio = $respuesta->appendChild($sitio);

if(!$idiomas = @include('../../cms2/datos/idiomas.php'))
 {
  error($error = "No fue posible recuperar los datos requeridos.");
  exit;
 }

$root = $doc->createElement('itemsLista');
//$root = $doc->appendChild($doc->createElementNS("bng5:cms2", "itemsLista"));
//xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:yahoo:yn" xsi:schemaLocation="urn:yahoo:yn http://api.search.yahoo.com/NewsSearchService/V1/NewsSearchResponse.xsd" totalResultsAvailable="202" totalResultsReturned="10" firstResultPosition="1">
$root = $doc->appendChild($root);
$schema = $doc->createAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'xsi:noNamespaceSchemaLocation');
$schema->value = "/xml/xsd/idiomas";
$root->appendChild($schema);
foreach($idiomas AS $sec_k => & $sec_v)
 {
  $idioma = $doc->createElement("item");
  //$idioma->setAttribute("xml:id", $sec_k);
$id = $doc->createAttributeNS("http://www.w3.org/XML/1998/namespace", "xml:id");
$id->value = $sec_k;
$idioma->appendChild($id);
  $idioma = $root->appendChild($idioma);
  $dato = $doc->createElement('texto');
$leng = $doc->createAttributeNS("http://www.w3.org/XML/1998/namespace", "xml:leng");
//$dato->setAttribute("xml:leng", $sec_k);
$leng->value = $sec_k;
$dato->appendChild($leng);
  if($sec_v['dir'] != 'ltr')
	$dato->setAttribute("dir", $sec_v['dir']);
  $dato->setAttribute("atributo", "idioma");
  $dato->appendChild($doc->createTextNode($sec_v['etiqueta']));
  $dato = $idioma->appendChild($dato);
$linkh = $doc->createAttributeNS("http://www.w3.org/1999/xlink", "xlink:href");
$linkh->value = "/xml/secciones/${sec_k}".(count($q) ? '?'.implode("&", $q): '');
$dato->appendChild($linkh);
$linkt = $doc->createAttributeNS("http://www.w3.org/1999/xlink", "xlink:type");
$linkt->value = "simple";
$dato->appendChild($linkt);

  if($sec_v['poromision'])
   {
	$dato->setAttribute("poromision", "true");
	//$dato = $doc->createElement('booleano');
	//$dato->appendChild($doc->createTextNode('true'));
	//$dato = $idioma->appendChild($dato);
   }
	/*
	 unset($sec_v['dir']);
	$idioma = $doc->createElement("item");
	$idioma->setAttribute("xml:id", $sec_k);
	$idioma = $root->appendChild($idioma);
	foreach($sec_v AS $k => $v)
	 {
	  if(is_bool($v))
	   {
		$dato = $doc->createElement('booleano');
		$v = $v ? 'true' : 'false';
	   }
	  else
	    $dato = $doc->createElement('texto');
	  $dato->appendChild($doc->createTextNode($v));
	  $dato = $idioma->appendChild($dato);
	  $dato->setAttribute('atributo', $k);
	 }*/
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