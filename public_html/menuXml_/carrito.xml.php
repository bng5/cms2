<?php

require_once('../../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');
//header('Content-type: text/plain; charset=utf-8');
$doc = new DOMDocument('1.0', 'utf-8');
//$doc->formatOutput = true;
//$root0 = $doc->createElement('xml');
//$root0 = $doc->appendChild($root0);

if(empty($_SESSION['usuario']))
 {
  $login_xml = 6;
  header("Cache-Control: no-cache, must-revalidate", true, 401);
  include(RUTA_CARPETA.'public_html/menuXml/login.xml.php');
  exit;
 }

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
file_put_contents(RUTA_CARPETA.'ww/carrito_'.time(), $buffer);
ob_end_clean();
//unset($_GET['sesion']);
//unset($_GET['accion']);

$root = $doc->createElement('pedido');
$root = $doc->appendChild($root);
$pedido_id = $_GET['id'] ? $_GET['id'] : ($_SESSION['pedido_id'] ? $_SESSION['pedido_id'] : false);

$mysqli = BaseDatos::Conectar();
if($_POST['pedido'])
 {
  if(!$pedido_id)
   {
	$mysqli->query("INSERT INTO carrito_pedidos (`usuario_id`, `fecha`) VALUES ({$_SESSION['usuario_id']}, now())");
	$pedido_id = $mysqli->insert_id;
	$_SESSION['pedido_id'] = $pedido_id;
   }
  $pedido = explode(",", $_POST['pedido']);
  $pedido_items_arr = array();
  foreach($pedido AS $pedido_items)
   {
   	$pedido_items = explode(":", $pedido_items);
   	if(is_numeric($pedido_items[0]))
   	 {
   	  if($pedido_items_arr[$pedido_items[0]])
	    $pedido_items_arr[$pedido_items[0]] += $pedido_items[1];
   	  else
	    $pedido_items_arr[$pedido_items[0]] = $pedido_items[1];
   	 }
   }
  foreach($pedido_items_arr AS $pi_k => $pi_v)
   {
   	if($pi_v)
   	 {
	  if(!$mysqli->query("INSERT INTO carrito_pedidos_items VALUES ({$pedido_id}, {$pi_k}, {$pi_v})"))
		$mysqli->query("UPDATE carrito_pedidos_items SET cantidad = {$pi_v} WHERE id = {$pedido_id} AND item_id = {$pi_k}");
	 }
	else
	  $mysqli->query("DELETE FROM carrito_pedidos_items WHERE id = {$pedido_id} AND item_id = {$pi_k}");
   }
 }

function enviar($pedido_id)
 {
  $mail = new PHPMailer();
  $mail->From     = "no-responder@".DOMINIO;
  $mail->FromName = SITIO_TITULO;
  $mail->Host     = "localhost";
  $mail->CharSet  = "utf-8";
  $mail->Mailer   = "sendmail";
  $mail->Subject = "Pedido";

  $mensaje = "<html>
  <head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
  <title>{$mail->Subject}</title>
  </head>
  <body><p>prueba</p>
  <p><a href=\"http://admin.".DOMINIO."/pedidos?id=${pedido_id}\">admin.".DOMINIO."/pedidos?id=${pedido_id}</a></p>
  <p>{$_SESSION['usuario_id']}: {$_SESSION['usuario']}</p>
  ";
  $txt_mensaje = "prueba
http://admin.".DOMINIO."/pedidos?id=${pedido_id}";

  $mensaje .= "
  </body>
  </html>";

  $mail->Body    = $mensaje;
  $mail->AltBody = $txt_mensaje;
  $mail->AddAddress("contactoeltoro@gmail.com", SITIO_TITULO);
  //$mail->AddBCC($address, $mail->FromName)
  return $mail->Send() ? 1 : 2;
/*
  if($mail->Send())
   {
   	global $doc, $suceso;
   	$suceso->setAttribute("id", "1");
   	$suceso->appendChild($doc->createTextNode("Su pedido ha sido enviado."));
   	echo $doc->saveXML();
	exit;
   }
  else
	return "2";
*/
 }

/*
sucesos
  enviado
  falló el envio
  importado
  no se encontró el pedido
*/

$sucesos = array(
  1 => "Su pedido ha sido enviado.",
  "No fue posible enviar su pedido.",
  "importado",
  "no se encontró el pedido",
  "Pedido activo",
  "No hay ningún pedido activo"
);

  $suceso = $doc->createElement("suceso");
  $suceso = $root->appendChild($suceso);
  $suceso_id = 5;

if($pedido_id)
 {
  $resultado = $mysqli->query("SELECT cpi.* FROM `carrito_pedidos_items` cpi JOIN `carrito_pedidos` cp ON cpi.id = cp.id WHERE cpi.id = {$pedido_id} AND usuario_id = {$_SESSION['usuario_id']}");
  if($fila = $resultado->fetch_row())
   {
   	if($_REQUEST['accion'])
   	 {
   	  switch($_REQUEST['accion'])
   	   {
		case "importar":
		  $_SESSION['pedido_id'] = $fila[0];
		  break;
		case "enviar":
		  $suceso_id = enviar($pedido_id);
		  break;
	   }
	 }
	$root->setAttribute("id", $pedido_id);
   	$carrito = $doc->createElement("carrito");
   	$carrito = $root->appendChild($carrito);
    do
     {
	  $item = $doc->createElement("item");
	  $item->setAttribute("xml:id", $fila[1]);
	  $item->setAttribute("cantidad", $fila[2]);
	  $item = $carrito->appendChild($item);
     }while($fila = $resultado->fetch_row());
   }
  else
   {
	$suceso_id = 4;
   }
 }
else
  $suceso_id = 6;
if($suceso_id == 1)
 {
  unset($_SESSION['pedido_id']);
 }
   	$suceso->setAttribute("id", $suceso_id);
   	$suceso->appendChild($doc->createTextNode($sucesos[$suceso_id]));

exit($doc->saveXML());

function error($error = "Ha ocurrido un error inesperado.")
 {
  global $doc, $root0;
  //header("HTTP/1.0 404 Not Found");
  $root = $doc->createElement('error');
  $root->appendChild($doc->createTextNode($error));
  $root = $root0->appendChild($root);
  echo $doc->saveXML();
  exit;
 }

?>