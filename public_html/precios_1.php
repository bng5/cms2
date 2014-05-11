<?php

include('../inc/iniciar.php');
if($_GET['accion'] == 'descarga')
 {
  $descarga = true;
  header("Content-Type: text/csv; charset=utf-8");
  //header("Pragma: public");
  //header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  //header("Content-Type: application/force-download");
  //header("Content-Type: application/octet-stream");
  //header("Content-Type: application/download");;
  header("Content-Disposition: attachment; filename=EPSEurope.csv");
  //header("Content-Transfer-Encoding: binary ");
  echo "\"".implode("\",\"", array("IMPRESSORES", "", "", "", "", ""))."\"
";
  //$xls->addRow(array("", "", "", "", "", ""));
 }
else
 {
  header('Content-type: application/xml; charset=utf-8');
  $doc = new DOMDocument('1.0', 'utf-8');
  if($_GET['salida'] == 'xslt')
    $doc->appendChild(new DOMProcessingInstruction('xsl-stylesheet', 'type="text/xsl" href="/xsl/precios.xsl"'));
  $xml = $doc->appendChild($doc->createElement('xml'));
 }

if($_SESSION['usuario_id'])
 {
  if($planilla = EPSModelo_UsuariosUltPlanilla::Listado($_SESSION['usuario_id']))
   {
	if(!$descarga)
	 {
      $items = $xml->appendChild($doc->createElement('items'));
      $items->setAttribute("etiqueta", "IMPRESSORES");
      $items->setAttribute("total", $planilla->total);
      $items->setAttribute("rpp", $planilla->total);
      $items->setAttribute("pagina", 1);
      $items->setAttribute("paginas", 1);
	 }
    if($planillaItems = $planilla->getIterator())
     {
	  $tipo = 0;
	  $tipos = array(1 => array("Tinta", "ml"), 2 => array("Tóner", "Págs."));
	  foreach($planillaItems AS $v)
       {
	    if($descarga)
	     {
		  if($v->tipo != $tipo)
		   {
		    $tipo = ($insumo_tolower == 'tinta') ? 1 : 2;
			echo "\"".implode("\",\"", array("", "", "", "", "", ""))."\"
\"".implode("\",\"", array("Marca", "Tipus", $tipos[$tipo][0], $tipos[$tipo][1], "Re Manufacturado", "Original"))."\"
";
		   }
		  $fila = array($v->marca, $v->modelo, $v->insumo, $v->getRendimiento(), '€ '.$v->getPrecioReman(), '€ '.$v->getPrecioNuevo());
		  echo "\"".implode("\",\"", $fila)."\"
";
		  continue;
	     }
		$item = $items->appendChild($doc->createElement('item'));
	    $item->setAttribute("xml:id", $v->id);
	    $item->setAttribute("tipo", $v->getTipoIdentif());
	    $dato = $item->appendChild($doc->createElement('dato', $v->marca));
	    $dato->setAttribute('tipo', "texto");
	    $dato->setAttribute('id', "marca");

	    $dato = $item->appendChild($doc->createElement('dato', $v->modelo));
	    $dato->setAttribute('tipo', "texto");
	    $dato->setAttribute('id', "tipus");

	    $dato = $item->appendChild($doc->createElement('dato', $v->insumo));
	    $dato->setAttribute('tipo', "texto");
	    $dato->setAttribute('id', $v->getTipoIdentif());

	    $dato = $item->appendChild($doc->createElement('dato', $v->getRendimiento()));
	    $dato->setAttribute('tipo', "entero");
	    $dato->setAttribute('valor', $v->rendimiento);
	    $dato->setAttribute('id', $v->getRendimientoUnIdentif());

	    $dato = $item->appendChild($doc->createElement('precio', '€ '.$v->getPrecioReman()));
	    $dato->setAttribute('valor', $v->precio_reman);
	    $dato->setAttribute('id', 're_manufacturado');

	    $dato = $item->appendChild($doc->createElement('precio', '€ '.$v->getPrecioNuevo()));
	    $dato->setAttribute('valor', $v->precio_nuevo);
	    $dato->setAttribute('id', 'original');
	   }
     }
   }
 }
if($descarga)
  exit;//$xls->download("EPSEurope.xls");
else
  exit($doc->saveXML());

?>