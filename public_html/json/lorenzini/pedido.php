<?php

require('../../../inc/iniciar.php');
if(!$_SESSION['usuario_id'])
 {
  header("Content-Type: application/json; charset=UTF-8", true, 401);
  exit(' ');
 }

if($_SERVER['REQUEST_METHOD'] == 'POST')
 {
  $pedido = new Pedido($_SESSION['usuario_id']);
  foreach($_POST['i'] AS $item_id => $cantidad)
    $pedido->agregarItem($item_id, $cantidad);
 }

$destinatarios = file('../../../.emailcontacto');
function arraytrim(&$valor)
 {
  $valor = trim($valor);
 }
array_walk($destinatarios, 'arraytrim');
$usuario = Modelo_Usuarios::getPorId($_SESSION['usuario_id']);
//file_put_contents('./ww/'.time(), var_export($pedido, true));
// PARA EL ADMINISTRADOR
$email = current($destinatarios);
//$email = 'pablobngs@gmail.com';
$mail = new PHPMailer();
$mail->From     = "no-responder@".DOMINIO;//$_SERVER['SERVER_NAME'];
$mail->FromName = SITIO_TITULO;
$mail->Host     = "localhost";
$mail->CharSet  = "utf-8";
$mail->Mailer   = "sendmail";
$mail->Subject = 'Nuevo pedido en '.SITIO_TITULO;//$_POST['__asunto'] ? $_POST['__asunto'] : "Formulario de contacto en ".SITIO_TITULO;
$mail->Body    = 'El usuario '.$usuario->nombre_mostrar.' ( http://admin.'.DOMINIO.'/usuarios?id='.$usuario->id.' ) ha realizado un pedido: http://admin.'.DOMINIO.'/pedidos?id='.$pedido->id.'
';
$mail->AddAddress($email, $mail->FromName);
$mail->AddBCC('pablo@bng5.net');
$enviado = $mail->Send();

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($_POST);

?>