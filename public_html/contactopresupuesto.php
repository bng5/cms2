<?php

require('../inc/iniciar.php');
if(!is_array($_POST)) exit;

$destinatarios = file('../.emailcontacto');

$post = $_POST;

function arraytrim(&$valor)
 {
  $valor = trim($valor);
 }

array_walk($destinatarios, 'arraytrim');

if(!empty($_POST['__destinatario']) && in_array($_POST['__destinatario'], $destinatarios))
  $email = $_POST['__destinatario'];
else
  $email = current($destinatarios);

$mail = new PHPMailer();
$mail->From     = "no-responder@".DOMINIO;
$mail->FromName = SITIO_TITULO;
$mail->Host     = "localhost";
$mail->CharSet  = "utf-8";
$mail->Mailer   = "sendmail";
$mail->Subject = "Confirmación de recepción de pedido.";
$mail->AltBody  = '

  EPS Europe 2009

Gracias por comunicarse con nosotros, nos pondremos en contacto en un plazo de 24 horas.
EPS Europe2009

Av. Turó D\'en Llull 37
08392 Sant Andreu de Llavaneres
http://epseurope2009.com
Tel	+ 34 652 09 55 65
Fax	+ 34 93 79 300 79
';
  // <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  $mail->Body    = '<html><head><title>'.SITIO_TITULO.'</title><meta http-equiv="content-type" content="text/html; charset=UTF-8" ><meta http-equiv="Content-Style-Type" content="text/css" ></head><body style="padding:19px 28px;">
<div style="width:475px;margin:0 auto;"><a href="http://epseurope2009.com"><img src="http://epseurope2009.com/img/email_cabezal" alt="EPS Europe 2009" width="157" height="23" border="0"></a>
<p style="color:#19936c;font:normal 13px serif;">Gracias por comunicarse con nosotros, nos pondremos en contacto en un plazo de 24 horas.</p>
<img src="http://epseurope2009.com/img/email_pie" alt=""><address style="color:#19936c;font:normal 13px sans-serif;">Av. Turó D\'en Llull 37<br>08392 Sant Andreu de Llavaneres<br><a href="http://epseurope2009.com" style="color:#19936c;">epseurope2009.com</a></address>
<table style="color:#19936c;font:normal 13px sans-serif;" cellpadding="0" border="0"><tr><td height="25" width="35"><img src="http://epseurope2009.com/img/email_telefono" alt="Tel"></td><td valign="middle">+ 34 652 09 55 65</td></tr><tr><td  valign="middle" height="25">Fax</td><td valign="middle">+ 34 93 79 300 79</td></tr></table></div></body></html>';



$mail->AddAddress($_POST['mail'], $_POST['persona']);
$mail->Send();
unset($mail);

$mail = new PHPMailer();
$mail->From     = "no-responder@".$_SERVER['SERVER_NAME'];
$mail->FromName = SITIO_TITULO;
$mail->Host     = "localhost";
$mail->CharSet  = "utf-8";
$mail->Mailer   = "sendmail";
$mail->Subject = $_POST['__asunto'] ? $_POST['__asunto'] : "Formulario de contacto en ".SITIO_TITULO;

$mensaje = "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>{$mail->Subject}</title>
<style type=\"text/css\">
body {margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;}
</style>
</head>
<body>";
$txt_mensaje = "";

$etiquetas = array();
$clave_omitir = array("onLoad", "onData", "onHTTPStatus", "__destinatario", "__asunto");
foreach($_POST AS $post_k => $post_v)
 {
  if(in_array($post_k, $clave_omitir))
   {
	unset($_POST[$post_k]);
	continue;
   }
  if(substr($post_k, 0, 9) == "etiqueta_")
   {
   	$etiquetas[substr($post_k, 9)] = $post_v;
	unset($_POST[$post_k]);
   }
 }

foreach($_POST AS $post_k => $post_v)
 {
  if($post_k == "email")
    $mail->AddReplyTo($post_v);
  $etiqueta = $etiquetas[$post_k] ? $etiquetas[$post_k] : $post_k;
  $mensaje .= "<u>${etiqueta}</u>: ${post_v}<br>\n";
  $txt_mensaje .= "${etiqueta}: ${post_v}\n";
 }

$mensaje .= "
</body>
</html>";

$mail->Body    = $mensaje;
$mail->AltBody = $txt_mensaje;
$mail->AddAddress($email, $mail->FromName);
echo $mail->Send();

/*
ob_start();
echo "envio: ${envio}\n";
echo "server\n";
print_r($_SERVER);
echo "destinatarios\n";
print_r($destinatarios);
echo "post\n";
print_r($post);
echo "get\n";
print_r($_GET);
echo "files\n";
print_r($_FILES);
$buffer = ob_get_contents();
file_put_contents('./ww/'.time(), $buffer);
ob_end_clean();
*/

?>