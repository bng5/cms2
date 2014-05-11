<?php

require_once('../../inc/iniciar.php');
header("Content-type: text/plain; charset=utf-8");
if(!$secciones = include('../../cms2/datos/secciones.php'))
 {
  echo '{"error" : true}';
  exit;
 }

include('../../cms2/estruct/__secciones.php');

function imprimir_secciones(&$secciones, $nivel = 0)
 {
  global $s;
  foreach($secciones AS $sec_k => &$sec_v)
   {

    $sec_v['algo'] = "nuevo";
	$sec_v = $s->Atributos($sec_v);


	foreach($sec_v AS $k => &$v)
	 {
	  if($k == 'secciones' && count($v))
	   {
	    imprimir_secciones($v, ++$nivel);
	    $nivel--;
	   }
//	  else
//	   {
//		if(is_bool($v))
//		  $v = $v ? 'true' : 'false';
//	   }
//
	 }
   }
 }

if($path = trim($_SERVER['PATH_INFO'], "/"))
 {
  $path_arr = explode("/", $path);
  $leng = $path_arr[0];
 }
else
  $leng = false;
$s = new Validar($atributos, $leng);
imprimir_secciones($secciones);


echo json_encode($secciones);

?>