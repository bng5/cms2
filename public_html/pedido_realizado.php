<?php
require('../inc/iniciar.php');
$datos_seccion = include('../cms2/datos/seccion/40.es.php');
$titulo = htmlspecialchars($datos_seccion[57]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es" lang="es">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
 <title><?= $titulo.' - '.SITIO_TITULO ?></title>
 <link rel="stylesheet" href="/css/eps/confirmar_pedido.css" />
 <!-- script type="text/javascript" src="/js/eps/pedido.js" charset="utf-8"></script -->
</head>
<body>
 <h1><?= $titulo ?></h1>
 <p><?= nl2br(htmlspecialchars($datos_seccion[58])) ?></p>
</body>
</html>