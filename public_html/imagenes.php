<?php

require('../inc/iniciar.php');

if($path = trim($_SERVER['PATH_INFO'], "/"))
 {
  $archivo_arr = explode("/", $path);
  $archivo_orig = '../img/'.$archivo_arr[2];
  $archivo = "./img/{$archivo_arr[0]}/{$archivo_arr[1]}/{$archivo_arr[2]}";

   if(file_exists($archivo))
   {
	$archivo_size = @getimagesize($archivo);
	header('Content-type: '.$archivo_size['mime']);
	readfile($archivo);
	exit;
   }

  $mysqli = BaseDatos::Conectar();
  $cons_campo = $mysqli->query("SELECT extra FROM items_atributos WHERE id = {$archivo_arr[1]}");
  if($fila_campo = $cons_campo->fetch_row())
   {
	if($fila_campo[0]) eval('$extra = '.$fila_campo[0].';');
	$metodos = $extra[$archivo_arr[0]] ? $extra[$archivo_arr[0]] : false;
   }

  $imagen = new Imagen($archivo_orig);
  if(!$imagen->dato('errorno'))
   {
    if($metodos)
     {
      $imagen->$metodos[0]($metodos[1], $metodos[2]);
      if(is_array($metodos[3])) $imagen->marcaDeAgua('./img/5/'.$metodos[3][0], $metodos[3][1], $metodos[3][2]);
     }
    $imagen->imprimir();
    $imagen->guardar("./img/{$archivo_arr[0]}/{$archivo_arr[1]}", $archivo_arr[2]);
   }
  else
   {
    $error = "no existe el archivo ".basename($archivo);
    header('content-type: image/png');
    $fuente = imagecreate(200, 150);
    $bg = imagecolorallocate($fuente, 224, 224, 224);
    $txtcolor = imagecolorallocate($fuente, 128, 0, 0);
    $texto = wordwrap($error, 24);
    $texto_arr = explode("\n", $texto);
    $txt_y = 5;
    for($i = 0; $i < count($texto_arr); $i++)
     {
      imagestring($fuente, 3, 10, $txt_y, $texto_arr[$i], $txtcolor);
	  $txt_y += 13;
     }
    imagepng($fuente);
   	// echo $imagen->dato('errorno');
   }
 }

?>