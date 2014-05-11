<?php

require_once('../../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');
//header('Content-type: text/plain; charset=utf-8');
$doc = new DOMDocument('1.0', 'utf-8');
$doc->formatOutput = true;
//$doc->appendChild(new DOMProcessingInstruction('xsl-stylesheet', 'type="text/xsl" href="/xsl/items.xsl"'));

if(!$secciones = include('../../cms2/datos/secciones.php'))
 {
  echo "error";
  exit;
 }




$root0 = $doc->createElement('xml');
$root0 = $doc->appendChild($root0);
if($path = trim($_SERVER['PATH_INFO'], "/"))
 {
  $path_arr = explode("/", $path);
  $leng = $path_arr[0];
 }

$idiomas = @include_once($_SERVER['DOCUMENT_ROOT'].'/../cms2/datos/idiomas.php');
$leng = $idiomas[$leng] ? $leng : $poromision;
$root0->setAttribute('xml:lang', $leng);
header("Content-Language: ${leng}");
include('../../cms2/estruct/__secciones.php');







/*********************************************************************/


//$root = $doc->createElement('itemsLista');
//$root = $root0->appendChild($root);
/*
function imprimir_secciones2($secciones, &$nodo, $nivel = 0)
 {
  global $doc, $s;
  $nodo = $nodo->appendChild($doc->createElement('itemsLista'));
  foreach($secciones AS $sec_k => $sec_v)
   {
$sec_v['algo'] = "nuevo";
	//$sec_v = $s->Atributos($sec_v);
	$seccion = $doc->createElement("item");
	$seccion->setAttribute("xml:id", $sec_v['identificador']);
	$seccion = $nodo->appendChild($seccion);
	foreach($sec_v AS $k => $v)
	 {
	  //if(is_string($v) && empty($v)) continue;
	  if($k == 'secciones' && count($v))
	   {
	    $lista = $doc->createElement('itemsLista');
	    $lista = $seccion->appendChild($lista);
	    imprimir_secciones($v, $lista, ++$nivel);
	    $nivel--;
	   }
	  else
	   {
		if(is_bool($v)) $v = $v ? 'true' : 'false';
		if(is_array($v))
		 {
		  if(count($v))
		   {
		   	$dato = $doc->createElement('alineacion');
		   	foreach($v AS $kk => $vv)
		   	 {
			  $el = $doc->createElement($k);
			  $el->setAttribute('xml:lang', $kk);
			  $el = $dato->appendChild($el);
			  $el->appendChild($doc->createTextNode($vv));
		   	 }
		   }
		 }
		else
		 {
		  $dato = $doc->createElement('dato');
		  $dato->setAttribute('type', gettype($v));
		  $dato->appendChild($doc->createTextNode($v));
		 }
		$dato = $seccion->appendChild($dato);
		$dato->setAttribute('id', $k);
	   }
	 }
   }
 }
*/

function imprimir_secciones($secciones, &$nodo, $nivel = 0)
 {
  global $doc, $s, $atributos, $leng, $poromision;
  $lista = $nodo->appendChild($doc->createElement('itemsLista'));
  foreach($secciones AS $sec)
   {
	//$sec_v = $s->Atributos($sec_v);
	$seccion = $doc->createElement("item");
	$seccion = $lista->appendChild($seccion);
foreach($atributos AS $attr_k => $attr_v)
   {

//	foreach($sec_v AS $k => $v)
//	 {
	  //if(is_string($v) && empty($v)) continue;
	  $nombre_nodo = 'dato';
	    switch($attr_v['tipo'])
		 {
		  case 'atributo':
			  $nom_attr_k = ($attr_k == 'id') ? 'xml:'.$attr_k : $attr_k;
			  $seccion->setAttribute($nom_attr_k, $sec[$attr_k]);
			  break;
		  case 'array':
			  if(count($sec[$attr_k]))
			   {
			   	$dato = $doc->createElement('alineacion');
			   	foreach($sec[$attr_k] AS $kk => $vv)
			   	 {
				  $el = $doc->createElement('dato');
				  $el->setAttribute('xml:lang', $kk);
				  $el = $dato->appendChild($el);
				  $el->appendChild($doc->createTextNode($vv));
			   	 }
			   }
			  break;			  
		  case 'itemsLista':
			if(count($sec[$attr_k]))
			 {
			  imprimir_secciones($sec[$attr_k], $seccion, ++$nivel);
			  $nivel--;
			 }
			break;
		  /*case 'url':
			  $nombre_nodo = 'enlace';
			  //$valor = $_SERVER["HTTP_HOST"].$valor;*/
		  case 'boolean':
			  $sec[$attr_k] = $sec[$attr_k] ? 'true' : 'false';

		  default:
			  $dato = $doc->createElement($nombre_nodo);
			  //$dato->setAttribute('type', $attr_v['type']);
			  $dato->setAttribute('tipo', $attr_v['tipo']);
			  if($attr_v['mleng'])
			   {
				$valor = $sec[$attr_k][$leng] ? $sec[$attr_k][$leng] : ($sec[$attr_k][$poromision] ? $sec[$attr_k][$poromision] : current($sec[$attr_k]));
			   }
			  else
			    $valor = $sec[$attr_k];
			  $dato->appendChild($doc->createTextNode($valor));
			  $dato = $seccion->appendChild($dato);
			  $dato->setAttribute('id', $attr_k);
			  break;

		 }


//	 }
   }
   }
 }

//$s = new Validar($atributos, $leng);
imprimir_secciones($secciones, $root0);
//$raiz = & $root0;
//$salida = salida($secciones);


//var_dump($secciones);

/*
	$root->setAttribute("total", $total);
	$root->setAttribute("rpp", $a);
	$root->setAttribute("pagina", $pagina);
	$root->setAttribute("paginas", $paginas);

		$item = $doc->createElement("item");
		$item->setAttribute("xml:id", $id);

			$dato = $doc->createElement("imagen");
			$v = explode(",", $v);
			$dato->setAttribute("archivo", "img/0/{$v[0]}");
			$dato->setAttribute("mime", $v[1]);
			$dato->setAttribute("peso", $v[2]);
			$dato->setAttribute("ancho", $v[3]);
			$dato->setAttribute("alto", $v[4]);
			$dato->setAttribute("miniatura", "img/1/{$v[0]}");
			$dato->setAttribute("ancho_m", $v[5]);
			$dato->setAttribute("alto_m", $v[6]);
			$dato->setAttribute("peso_m", $v[7]);

			$dato = $doc->createElement("archivo");
			$v = explode(",", $v);
			$dato->setAttribute("archivo", "archivos/".$v[0]);
			$dato->setAttribute("mime", $v[1]);
			$dato->setAttribute("peso", $v[2]);

			$dato = $doc->createElement("dato");
			if($k[0] == "date" && !empty($v)) $v = formato_fecha($v, true, false);
			elseif($k[0] == "datetime" && !empty($v)) $v = formato_fecha($v, true);
			$dato->appendChild($doc->createTextNode(str_replace("\r", "", $v)));
			$dato->setAttribute("tipo", $tipos[$k[0]]);

		  $dato->setAttribute("id", $k[1]);
		  $dato = $item->appendChild($dato);

		$item = $root->appendChild($item);
*/



echo $doc->saveXML();

function error($error = "Ha ocurrido un error inesperado.")
 {
  global $doc, $root0;
  //header("HTTP/1.0 404 Not Found");
  $root = $doc->createElement('error');
  $root->appendChild($doc->createTextNode($error));
  $root = $root0->appendChild($root);
  echo $doc->saveXML();
  exit;
 }

?>