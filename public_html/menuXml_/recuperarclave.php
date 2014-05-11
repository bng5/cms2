<?php

require_once('../../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');

if($_SESSION['usuario_id'])
  login_error(5, $_SESSION['usuario']);
elseif(!$_POST['usuario'])
  login_error(2, null);

/*else
 {
  if(empty($_POST["usuario"]) || empty($_POST["email"]))
   { login_error("Debe completar ambos campos.", $autousername); }
*/

  $usuario = $_POST["usuario"];
  $mysqli = BaseDatos::Conectar();
  if(!$result = $mysqli->query("SELECT `id`, `email`, `nombre_mostrar` FROM `usuarios` WHERE `usuario` = '${usuario}' LIMIT 1")) login_error(6, null);
  if($row = $result->fetch_row())
   {
    //$username = $row["usuario"];
    $id = $row[0];
    $email = $row[1];
    $nombre = $row[2];
    function generarpass($largo = 16)
	 {
	  $clave_caract = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789:.,";
	  $n_clave = "";
	  for ($i=0; $i < $largo; $i++)
	   { $n_clave .= substr($clave_caract, rand(1, strlen($clave_caract)), 1); }
	  return $n_clave;
	 }
    $clave = generarpass(15);
    $mysqli->query("UPDATE `usuarios` SET `aut` = '${clave}' WHERE `id` = '${id}' LIMIT 1");

/*
    if(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $row["admin_mail"]))
     {
*/

    $mail = new PHPMailer();
    $mail->Host     = "localhost";
    $mail->From     = "no_responder@".DOMINIO;
	$mail->CharSet  = "utf-8";
    $mail->FromName = SITIO_TITULO;
    $mail->Subject = "Recuperar contraseña";
    $mail->AddAddress($email, $nombre);
    $mail->Mailer   = "sendmail";
    //nl2br($encoded)
    $mail->Body = "
 ".SITIO_TITULO."

   Estimado ${nombre}:

Hemos recibido una petición para restablecer tu contraseña.

En caso de que el mensaje lo haya enviado otra persona o ya no te haga
falta, puedes ignorar esta notificación y seguir utilizando la
contraseña de siempre.

   Tu nombre de usuario
${usuario}

Para restablecer tu contraseña, pulsa en este enlace:
http://".DOMINIO."/xhtml/cambiar_clave/${clave}/${usuario}

Si el enlace no te funciona, también puedes copiar el URL y pegarlo
manualmente en tu navegador.
";

    if(!$mail->Send())
	  login_error(4, NULL);
    else
	  login_error(1, NULL);
   }
  else
   { login_error(3, $_POST['usuario']); }


function login_error($suceso_id, $usuario)
 {
  $sucesos = array(
  1 => "Las indicaciones para restaurar su contraseña han sido enviadas a su casilla de correo",
  "Debe indicar el nombre de usuario",
  "No se encontró el usuario '${usuario}'",
  "Ocurrió un error al intentar enviarle un correo electrónico",//.\nPor favor intentelo nuevamente.
  "Existe una sesión abierta",
  "Ocurrió un error interno de servidor"
 );
  $doc = new DOMDocument('1.0', 'utf-8');


  $root = $doc->createElement("recuperarclave");
  $root = $doc->appendChild($root);


  $suceso = $doc->createElement("suceso");
  $suceso = $root->appendChild($suceso);
  $suceso->setAttribute("id", $suceso_id);
  $suceso->appendChild($doc->createTextNode($sucesos[$suceso_id]));


  echo $doc->saveXML();
  exit;
 }
?>