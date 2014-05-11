<?php

require('../inc/iniciar.php');
$datos_seccion = include('../cms2/datos/seccion/40.es.php');

if($_POST['accion'] == 'confirmar')
 {
  $pedido = new EpsAR_Pedido;
  foreach($_SESSION['pedido'] AS $k => $v)
   {
	if($v[0])
	  $pedido->agregar($k, 0, $v[0]);
	if($v[1])
	  $pedido->agregar($k, 1, $v[1]);
   }
  unset($_SESSION['pedido']);

  $destinatarios = file('../.emailcontacto');
  function arraytrim(&$valor)
   {
    $valor = trim($valor);
   }
  array_walk($destinatarios, 'arraytrim');
  $usuario = Modelo_Usuarios::getPorId($_SESSION['usuario_id']);
  // PARA EL ADMINISTRADOR
  $email = current($destinatarios);
  $mail = new PHPMailer();
  $mail->From     = "no-responder@".DOMINIO;//$_SERVER['SERVER_NAME'];
  $mail->FromName = SITIO_TITULO;
  $mail->Host     = "localhost";
  $mail->CharSet  = "utf-8";
  $mail->Mailer   = "sendmail";
  $mail->Subject = $datos_seccion[60];//$_POST['__asunto'] ? $_POST['__asunto'] : "Formulario de contacto en ".SITIO_TITULO;
  $mail->Body    = 'El usuario '.$usuario->nombre_mostrar.' ( http://admin.epseurope2009.com/usuarios?id='.$usuario->id.' ) ha realizado un pedido: http://admin.'.DOMINIO.'/pedidos?id='.$pedido->id.'
';
  $mail->AddAddress($email, $mail->FromName);
  $mail->AddBCC('pablo@bng5.net');
  $enviado = $mail->Send();

  // PARA EL CLIENTE
  //$email = 'contactoeltoro@gmail.com';//current($destinatarios);
  $mail = new PHPMailer();
  $mail->From     = "info@".DOMINIO;//$_SERVER['SERVER_NAME'];
  $mail->FromName = SITIO_TITULO;
  $mail->Host     = "localhost";
  $mail->CharSet  = "utf-8";
  $mail->Mailer   = "sendmail";
  $mail->Subject  = $datos_seccion[60];//$_POST['__asunto'] ? $_POST['__asunto'] : "Formulario de contacto en ".SITIO_TITULO;
  $mail->AltBody  = '

  EPS Europe 2009

'.$datos_seccion[59].'

Av. Turó D\'en Llull 37
08392 Sant Andreu de Llavaneres
http://epseurope2009.com
Tel	+ 34 652 09 55 65
Fax	+ 34 93 79 300 79
';
  // <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  $mail->Body    = '<html><head><title>'.SITIO_TITULO.'</title><meta http-equiv="content-type" content="text/html; charset=UTF-8" ><meta http-equiv="Content-Style-Type" content="text/css" ></head><body style="padding:19px 28px;">
<div style="width:475px;margin:0 auto;"><a href="http://epseurope2009.com"><img src="http://epseurope2009.com/img/email_cabezal" alt="EPS Europe 2009" width="157" height="23" border="0"></a>
<p style="color:#19936c;font:normal 13px serif;">'.$datos_seccion[59].'</p>
<img src="http://epseurope2009.com/img/email_pie" alt=""><address style="color:#19936c;font:normal 13px sans-serif;">Av. Turó D\'en Llull 37<br>08392 Sant Andreu de Llavaneres<br><a href="http://epseurope2009.com" style="color:#19936c;">epseurope2009.com</a></address>
<table style="color:#19936c;font:normal 13px sans-serif;" cellpadding="0" border="0"><tr><td height="25" width="35"><img src="http://epseurope2009.com/img/email_telefono" alt="Tel"></td><td valign="middle">+ 34 652 09 55 65</td></tr><tr><td  valign="middle" height="25">Fax</td><td valign="middle">+ 34 93 79 300 79</td></tr></table></div></body></html>';
  $mail->AddAddress($usuario->email, $usuario->nombre_mostrar);

  $db = DB::instancia();
  $usuario_valores = $db->query("SELECT `atributo_id`, `string` FROM usuarios_valores WHERE usuario_id = ".$usuario->id);
  $usuario_valores->setFetchMode(DB::FETCH_NUM);
  foreach($usuario_valores AS $uv)
   {
	if($uv[0] == 61)
	  $mail->AddCC($uv[1]);
	if($uv[0] == 62)
	  $mail->AddBCC($uv[1]);
   }
  $enviado = $mail->Send();

  header("Location: /pedido_realizado");
  exit(" ");
 }

$_SESSION['pedido'] = array();
$titulo = htmlspecialchars($datos_seccion[55]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es-uy" lang="es-uy">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
 <title><?= $titulo.' - '.SITIO_TITULO ?></title>
 <link rel="stylesheet" href="/css/eps/confirmar_pedido.css" />
 <!-- script type="text/javascript" src="/js/eps/pedido.js" charset="utf-8"></script -->
</head>
<body>

<h1><?= $titulo ?></h1>
<p><?= nl2br(htmlspecialchars($datos_seccion[56])) ?></p>
<div id="confirmacion">
<?php

  $i = 0;
  if($planilla = EPSModelo_UsuariosUltPlanilla::Listado($_SESSION['usuario_id']))
   {
    if($planillaIt = $planilla->getIterator())
	 {
	  $tabla = new EPSVista_FacturaPedido;
	  foreach($planillaIt AS $item)
	   {
		if($_POST['pedido'][0][$item->id])
		 {
		  $i++;
		  $_SESSION['pedido'][$item->id][0] = $_POST['pedido'][0][$item->id];
		  $tabla->fila($item, 0, $_POST['pedido'][0][$item->id]);
		 }
		if($_POST['pedido'][1][$item->id])
		 {
		  $i++;
		  $_SESSION['pedido'][$item->id][1] = $_POST['pedido'][1][$item->id];
		  $tabla->fila($item, 1, $_POST['pedido'][1][$item->id]);
		 }
	   }
	  unset($tabla);
	 }
   }

if($i >= 1)
 {
?>

<form action="/confirmar_pedido" method="post">
 <input type="hidden" name="accion" value="confirmar" />
 <p><input type="button" onclick="document.location.href='/precios'" value="Modificar pedido" /> <input type="submit" value="Confirmar" /></p>
</form>
</div>
<?php
 }
else
 {
?>

<div class="error">
 <p>No ha seleccionado ningún producto.</p>
 <p><button type="button" onclick="document.location.href='/precios'">Regresar</button></p>
</div>
<?php
 }
?>

</body>
</html>