<?php

require('../inc/iniciar.php');
@include('./inc_xhtml/idiomas.php');
$dom_arr = explode(".", $_SERVER['HTTP_HOST']);
array_pop($dom_arr);
$dom = strtolower(end($dom_arr));

$sel_idioma = $idiomas[$_GET['leng']] ? $_GET['leng'] : $poromision;
//@include('./inc_xhtml/secciones.php');
//$sel_seccion = trim($_SERVER['PATH_INFO'], "/");
//$rr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//if($sel_idioma != $poromision) $p_leng = "leng=${sel_idioma}";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= SITIO_TITULO; ?></title>
<script type="text/javascript" src="<?php echo PRINCIPALURL; ?>js/swfobject.js"></script>
<script type="text/javascript">
// <![CDATA[
function onProgress(e)
 {
  porc.innerHTML = Math.round((e.position / e.totalSize)*100)+' %';
 }

function onError(e)
 {
  //alert("Error " + e.target.status + " occurred while receiving the document.");
  alert("Error");
 }

function onLoad(e)
 {
  var fo = new SWFObject("./peliculaCentral.swf", "pelicula", "100%", "100%", "8");
  fo.addVariable("leng", "<?= $sel_idioma ?>");
  //fo.addVariable("seccion", "<?= $seccion_act ?>");
  fo.addParam("scale", "exactfit");
  fo.addParam("menu", "false");
  //fo.addParam("wmode", "transparent");
  fo.write("flashcontent3");
 }

var req;
var porc;
function cargarXml(url, hand)
 {
  req = false;
  if(window.XMLHttpRequest)
   {
	try
	 { req = new XMLHttpRequest(); }
    catch(e)
     { req = false; }
   }
  else if(window.ActiveXObject)
   {
    try
     { req = new ActiveXObject("Msxml2.XMLHTTP"); }
    catch(e)
     {
      try
       { req = new ActiveXObject("Microsoft.XMLHTTP"); }
      catch(e)
       { req = false; }
	 }
   }
  if(req)
   {
    //req.onprogress = onProgress;
    //req.onload = onLoad;
    req.onreadystatechange = hand;
	//req.onerror = onError;
    req.open("GET", url, true);
    req.send(null);
   }
  else
   { alert('Su navegador no cuenta con, al menos, uno de los m\xE9todos necesarios para el funcionamiento de este sistema.'); }
 }

function cargar()
 {
  if(req.readyState == 4)
   {
	var fo = new SWFObject("./peliculaCentral.swf", "pelicula", "100%", "100%", "8");
	fo.addVariable("leng", "<?= $sel_idioma ?>");
	//fo.addVariable("seccion", "<?= $seccion_act ?>");
	fo.addParam("scale", "exactfit");
	fo.addParam("menu", "false");
	//fo.addParam("wmode", "transparent");
	fo.write("flashcontent3");
   }
 }
function iniciarCarga()
 {
  porc = document.getElementById('requerimiento');
  cargarXml('./peliculaCentral.swf', cargar);
  var fo = new SWFObject("./preload.swf", "pelicula", "100%", "100%", "8");
  fo.addParam("scale", "exactfit");
  fo.addParam("menu", "false");
  fo.write("flashcontent3");
 }
// ]]>
</script>
<link type="text/css" rel="stylesheet" media="screen" href="<?php echo PRINCIPALURL; ?>css/pagina.css" />
</head>
<body onload="iniciarCarga()">
<div id="flashcontent3">
 <div id="flashcontent3_alt">
  <h1 id="logo"><?= SITIO_TITULO; ?></h1>
  <p id="requerimiento">Para visualizar este sitio, su navegador debe contar con JavaScript habilitado.</p>
 </div>
 <div id="eltorodepicasso"><a href="http://www.eltorodepicasso.es" target="_blank">eltorodepicasso.es</a></div>
</div>
</body>
</html>