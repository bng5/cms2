<?php

require_once('../../inc/iniciar.php');
//header("HTTP/1.0 401 Unauthorized");
header('Content-type: application/xml; charset=utf-8');

if(!empty($_GET['ref'])) $ref = $_GET['ref'];

if($login_xml)
  login_xml($login_xml);
if($_REQUEST['accion'] != "cerrar" && !empty($_SESSION['usuario']))
 {
  login_xml(5);
 }

function cerrar_sesion()
 {
  if($_SESSION['usuario'])
   {
    session_unset();
    $cod = null;
    if(session_destroy())
	  $cod = 4;
    setcookie("sesion", '', time(), "/");
   }
  return $cod;
 }

if($_REQUEST["accion"] == "cerrar")
 {
  /*
  if($_SERVER['PHP_AUTH_USER'] && $_SERVER['PHP_AUTH_PW'])
   {
	header('WWW-Authenticate: Basic realm="Autentificación Requerida"');
	header('HTTP/1.0 401 Unauthorized');
	//echo "You must enter a valid login ID and password to access this resource\n";
	//exit;
   }
  */
  login_xml(cerrar_sesion());
 }

elseif($_REQUEST["accion"] == "login")
 {
  cerrar_sesion();
  $username = $_POST["usuario"];
  if(empty($username) || empty($_POST['clave']))
   { login_xml(1); }
$mysqli = BaseDatos::Conectar();
  if(!$result = $mysqli->query("SELECT `id`, `usuario` FROM `usuarios` WHERE `usuario` = '${username}' AND `clave` = SHA1('{$_POST["clave"]}') LIMIT 1")) login_xml(8);
  if($fila = $result->fetch_assoc())
   {
	session_start();
	$_SESSION['usuario'] = $fila['usuario'];
	$_SESSION['usuario_id'] = $fila['id'];
    setcookie("usuario", $fila['usuario'], 0, '/', '.'.DOMINIO);
	//$mysqli->query("INSERT INTO usuarios_accesos (`usuario_id`, `sesion_id`, `ip`, `uri`) VALUES ({$fila['id']}, '".session_id()."', '{$_SERVER['REMOTE_ADDR']}', '{$_POST['ref']}')");
	$consultaperm = $mysqli->query("SELECT s.identificador, up.`permiso_id` FROM `usuarios_permisos` up JOIN secciones s ON up.`item_id` = s.id WHERE up.`area_id` = 1 AND up.`usuario_id` = '{$fila["id"]}'");
	if($fila_perm = $consultaperm->fetch_row())
	 {
	  //$pase = md5(rand().time());
	  //$mysqli->query("UPDATE usuarios SET `pase` = '{$pase}' WHERE id = {$fila['id']}");
	  //setcookie("pase", $pase);
	  //setcookie("usuario", $fila['usuario'], time()+2592000);//60*60*24*30
	  do
	   {
		$_SESSION['permisos'][$fila_perm[0]] = $fila_perm[1];
	   }while($fila_perm = $consultaperm->fetch_row());
	  $consultaperm->close();
	  $result->close;
	  login_xml(3);
	 }
	$result->close;
	//else login_xml(7);




	/*
	$consultaperm = $mysqli->query("(SELECT cliente_id, obra_id FROM usuarios_permisos WHERE `usuario_id` = ".$fila["id"].") UNION (SELECT `int`, NULL FROM usuarios_valores WHERE usuario_id = ".$fila["id"]." AND atributo_id = 3)");
	if($fila_perm = $consultaperm->fetch_row())
	 {
	  do
	   {
	    $cliente = $fila_perm[0];
		$obra = $fila_perm[1];
		if($cliente) $_SESSION['permisos']['clientes'][$cliente] = true;
		elseif($obra) $_SESSION['permisos']['obras'][$obra] = true;
	   }while($fila_perm = $consultaperm->fetch_row());
	  // $nombre_comp = $row["admin_nombre"]." ".$row["admin_apellido"];
	  $consultaperm->close();
	 }
	else login_xml(7);
	*/
// no debería llegar hasta acá
	//session_start();
	//setcookie("usuario", $fila['usuario'], time()+2592000, "/");
	//$_SESSION['usuario'] = $fila["usuario"];
	//$_SESSION['usuario_id'] = $fila["id"];
	//$result->close;
	//login_xml(3);
   }
  else
   { login_xml(2); }

  //$sesion = $_GET["sesion"];

  $ref = $_POST["ref"];
  $lgn = "lgn=si&";
 }
/*
if(!empty($_SESSION['usuario']))
 {
  $noref = array(php_self(), APU."recuperarclave.php", APU."error/404.php");
  if(empty($ref) || in_array($ref, $noref))
   { $ref = "./"; }

  setcookie("admin", $_SESSION['usuario'], time()+60*60*24*30);
  //setcookie("sesion", $sesion);
 }
else
 { login_error(NULL, $autousername); }
*/

$ses_suceso = $ses_suceso ? $ses_suceso : 6;
login_xml($ses_suceso);

function login_xml($suceso = 6)
 {
  $mensajes = array(
	1 => "Debe completar ambos campos para ingresar.",
	"Los datos proporcionados no son correctos.",
	"Acceso aceptado.",
	"Su sesión ha sido cerrada satisfactoriamente.",
	"Sesión activa.",
	"Su sesión ha expirado o no ha iniciado una.",
	"Usted no tiene permisos para acceder a este documento.",
	"No fue posible conectar con la base de datos.");
  if((isset($_SESSION['usuario']) && isset($_SESSION['usuario_id'])) && $suceso != 7 && $suceso != 3)
    $suceso = 5;
  $doc = new DOMDocument('1.0', 'utf-8');
  $root = $doc->createElement('login');
  $root = $doc->appendChild($root);
  $suc = $doc->createElement('suceso');
  $suc->setAttribute("id", $suceso);
  $suc->appendChild($doc->createTextNode($mensajes[$suceso]));
  $suc = $root->appendChild($suc);
  if($suceso == 3 || $suceso == 5)
   {
	$usu = $doc->createElement('usuario');
	$usu->appendChild($doc->createTextNode($_SESSION['usuario']));
	$usu = $root->appendChild($usu);
	$ses = $doc->createElement('sesion');
	$ses->appendChild($doc->createTextNode(session_id()));
	$ses = $root->appendChild($ses);
   }
  echo $doc->saveXML();
  exit;
 }

?>