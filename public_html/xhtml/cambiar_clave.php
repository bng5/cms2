<?php

require('../../inc/iniciar.php');
$path = explode("/", trim($_SERVER['PATH_INFO'], " /"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es-uy" lang="es-uy">
<head>
 <meta http-equiv="content-type" content="text/html;charset=utf-8" />
 <title>Cambiar contraseña</title>
</head>
<body>
<h1><?= SITIO_TITULO ?></h1>


<?php

$mysqli = BaseDatos::Conectar();

$valid = $mysqli->query("SELECT id FROM usuarios WHERE usuario = '{$path[1]}' AND aut = '{$path[0]}' LIMIT 1");
if($fila = $valid->fetch_row())
 {


  if($_POST['clave'])
   {
	if(empty($_POST['clave1']) || empty($_POST['clave2']))
	 { $mensaje_error[] = "Ingrese la nueva contrase&ntilde;a dos veces."; }
	else
	 {
	  if(strlen($_POST['clave1']) < 6)
	   { $mensaje_error[] = "La nueva contrase&ntilde;a debe contener al menos 6 caracteres."; }
	  else
	   {
	    if($_POST['clave1'] !== $_POST['clave2']) $mensaje_error[] = "La nueva contrase&ntilde;a y su confirmaci&oacute;n no coinciden.";
	    else
	     {
	      $mysqli->query("UPDATE `usuarios` SET clave = SHA1('{$_POST['clave1']}'), aut = NULL WHERE `id` = '{$fila[0]}'");
	      if($mysqli->affected_rows)
	       {
	       	echo "<p>Su contraseña ha sido modificada satisfactoriamente.</p></body>
</html>";
exit;
	       	$listo = true;
	       }
	      else $mensaje_error[] = "Debido a un error en el servidor no fue posible cambiar su contraseña.";
		 }
	   }
	 }
   }


if($mensaje_error) echo "<div class=\"error\">{$mensaje_error[0]}</div>";
?>

<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
<fieldset>
<legend>Cambiar contraseña</legend>
 <ul>
  <li><label for="usuario">Usuario:</label> <span><?= $path[1] ?></span></li>
  <li><label for="clave1">Nueva contraseña:</label> <input type="password" name="clave1" id="clave1" /></li>
  <li><label for="clave2">Repita contraseña:</label> <input type="password" name="clave2" id="clave2" /></li>
  <li><input type="submit" name="clave" value="Enviar" /></li>
 </ul>
</fieldset>
</form>

<?php

 }
else
 {
  echo "<p>La URL ingresada no es correcta o el enlace ha expirado.</p>";
 }
?>
</body>
</html>