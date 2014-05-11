<?php

if($archivo = trim($_SERVER['PATH_INFO'], "/"))
 {
  $archivo = "./img/galerias/".$archivo;
  if(file_exists($archivo))
   {
    $archivo_size = @getimagesize($archivo);
    header('content-type: '.$archivo_size['mime']);
    if(!$_GET['max'] || ($archivo_size[0] <= $_GET['max'][0] && $archivo_size[1] <= $_GET['max'][0]))
     {
      readfile($archivo);
      exit;
     }
    elseif($max = $_GET['max'])
     {
	  if(($archivo_size[0] > $max[0]) || ($archivo_size[1] > $max[1]))
	   {
	    $proporcion = ($archivo_size[0] / $archivo_size[1]);
	    $proporcion_pred = ($max[0] / $max[1]);
	    $xdest = 0;
	    $ydest = 0;
	    if($proporcion > $proporcion_pred)
	     {
	      $div = ($archivo_size[1] / $max[1]);
	      $alto = $max[1];
	      $ancho = ceil($archivo_size[0] / $div);
	      $xdest -= ceil(($ancho - $max[0]) / 2);
	     }
	    if($proporcion < $proporcion_pred || $proporcion == $proporcion_pred)
	     {
	      $div = ($archivo_size[0] / $max[0]);
	      $ancho = $max[0];
	      $alto = ceil($archivo_size[1] / $div);
	      $ydest -= ceil(($alto - $max[1]) / 2);
	     }

	    switch($archivo_size[2])
         {
		  case 1:
		    $fuente = imagecreatefromgif($archivo);
		    $salida = "imagegif";
		    break;
		  case 2:
		    $fuente = imagecreatefromjpeg($archivo);
		    $salida = "imagejpeg";
		    break;
		  case 3:
		    $fuente = imagecreatefrompng($archivo);
		    $salida = "imagepng";
		    break;
         }

	    $imagen = imagecreatetruecolor($max[0], $max[1]);
	    imagecopyresampled($imagen, $fuente, $xdest, $ydest, 0, 0, $ancho, $alto, $archivo_size[0], $archivo_size[1]);

	    $salida($imagen);
	    //$this->ancho = $max_ancho;
	    //$this->alto = $max_alto;
	    //$this->fuente = $n_imagen;
	   }
     
/*
      $max = $_GET['max'];
      if($archivo_size[0] >= $archivo_size[1])
       {
		$div = ($archivo_size[0] / $max);
		$ancho = $max;
		$alto = ceil($archivo_size[1] / $div);
       }
      else
       {
		$div = ($archivo_size[1] / $max);
		$alto = $max;
		$ancho = ceil($archivo_size[0] / $div);
       }


      $imagen = imagecreatetruecolor($ancho, $alto); 
      imagecopyresampled($imagen, $fuente, 0, 0, 0, 0, $ancho, $alto, $archivo_size[0], $archivo_size[1]);
      $salida($imagen);
*/
     }
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
   }
 }

?>