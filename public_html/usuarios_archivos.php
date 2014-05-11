<?php

require('../inc/iniciar.php');
require('../inc/ad_sesiones.php');

$usuario_id = $_SESSION['usuario_id'];
$carpeta = RUTA_CARPETA.'/usuarios_archivos/'.$usuario_id;
if($path = $_SERVER['PATH_INFO'])
 {
  $archivo = RUTA_CARPETA.'usuarios_archivos/'.$usuario_id.urldecode($path);
  if(file_exists($archivo))
   {
    //header("Content-Type: ".mime_content_type($archivo));
    header("Content-Type: ".shell_exec("file -bi " . $archivo));
    header("Content-Length: ".filesize($archivo));
    header('Content-Disposition: attachment; filename="'.basename($archivo).'"');
    readfile($archivo);
    //$file = escapeshellarg($archivo);
    exit();
   }
  else
   {
    header("X-noex: ".$archivo);
   }
 }


function tamArchivo($bytes)
 {
  $unidades = array('bytes', 'KiB', 'MiB', 'GiB');
  $bytes = max($bytes, 0);
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
  $pow = min($pow, count($unidades) - 1);
  $bytes /= pow(1024, $pow);
  return round($bytes, 1) . ' ' . $unidades[$pow];
 }
$meses = array(1 => "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic");
$dias = array("Dom", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es-uy" lang="es-uy">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
 <title>Archivos <?= $_SESSION['usuario'] ?></title>
 <link rel="stylesheet" type="text/css" media="all" href="/css/scd/usuarios_archivos.css" />
</head>
<body>

    <h1><?= SITIO_TITULO ?></h1>
    
<?php


  try {
    $path = new DirectoryIterator(RUTA_CARPETA.'/usuarios_archivos/'.$usuario_id);
    echo '<table><tr><th>Archivo</th><th>Tamaño</th><th>Fecha</th></tr>';
    foreach($path as $file)
     {
      if($file->isDot())
        continue;
      echo '<tr><td><a href="/usuarios_archivos/'.urlencode($file->getFilename()).'">'.htmlspecialchars($file->getFilename()).'</a></td><td>'.tamArchivo($file->getSize()).'</td><td>'.date("d-", $file->getMTime()).$meses[date("n", $file->getMTime())].date("-Y G:i", $file->getMTime()).' hs.</td></tr>';
     }
    echo "</table>";
   } catch (Exception $e) {
    echo "<p>No existen archivos asociados a este usuario.</p>";
 }

?>

</body>
</html>