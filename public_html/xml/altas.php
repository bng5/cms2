<?php

/* FIXME
 * levantar sección del path
 */
$seccion_id = 11;
//$cat_id = $_POST['cat'];
require('../../inc/iniciar.php');
//require('inc/ad_sesiones.php');

$mensajes = array(
 'es' => array(
   'errores' => array(
	 1 => "Campo requerido",
	 "Tipo no válido",
	 "Valor incorrecto",
	 "Largo insuficiente",
	 "El campo excede la cantidad de caracteres máxima",
	 "Campo ignorado"),
   'mensajes' => array(
	 1 => "Aceptado",
	 "Error interno del servidor",
     "La petición no pudo ser interpretada",
     "Sin cambios",
     "Debe completar los campos obligatorios",
     "Existen datos con tipos incorrectos",
     "Existen datos incorrectos",
     "No fue posible completar su solicitud")));

$id = "false";
$modif = 0;
if($_POST)//["ia"] == "modificar"
 {
  $mysqli = BaseDatos::Conectar();
  $atributos = array();
  //$listado = array();
  if(!$atributos_tipos = $mysqli->query("SELECT ia.id, ia.identificador, ia.sugerido, ia.unico, isaa.en_listado, at.tipo, at.subtipo, asec.identificador AS seccion FROM items_atributos ia LEFT JOIN items_secciones_a_atributos isaa ON ia.id = isaa.atributo_id, atributos_tipos at, admin_secciones asec WHERE ia.tipo_id = at.id AND isaa.seccion_id = ${seccion_id} AND isaa.seccion_id = asec.id")) echo __LINE__." - ".$mysqli->error;
  if($fila_at = $atributos_tipos->fetch_assoc())
   {
   	//$seccion = $fila_at['seccion'];
	do
	 {
	  $fila_id = array_shift($fila_at);
	  $atributos[$fila_id] = $fila_at;
	  //if($fila_at['en_listado'] == 1)
	  //  $listado[] = $fila_id;
	 }while($fila_at = $atributos_tipos->fetch_assoc());
	$atributos_tipos->close();
   }

  $respuesta->exito = false;
  $respuesta->mensajes = array();
  $respuesta->errores = array();
  //$respuesta->ignorados = '';
  $inserciones = array();
  foreach($atributos AS $k => $v)
   {
    if(!$_POST[$v['identificador']])
	 {
	  if($v['sugerido'] == 2)
	   {
		$respuesta->errores[$v['identificador']] = 1;
		$respuesta->mensajes[5] = 5;
	   }
	  else
	    continue;
	 }
	/* FIXME
	 * agregar areadetexto no multilingüe
	 */
	if($v['tipo'] == 'text')
	  $inserciones[] = array("INSERT INTO items_valores (atributo_id, item_id, leng_id, `text`) VALUES (${k}, ",", 1, '{$_POST[$v['identificador']]}')");
    else
	  $inserciones[] = array("INSERT INTO items_valores (atributo_id, item_id, `{$v['tipo']}`) VALUES (${k}, ",", '{$_POST[$v['identificador']]}')");
	unset($_POST[$v['identificador']]);
   }

  if(count($respuesta->errores) == 0)
   {
   	$respuesta->exito = true;
	if(!$mysqli->query("INSERT INTO `items` (`seccion_id`, `f_creado`) VALUES (${seccion_id}, now())")) die ("\n".__LINE__." mySql: ".$mysqli->error);
	if($id = $mysqli->insert_id)
	  $modif++;
	foreach($inserciones AS $v)
	  $mysqli->query($v[0].$id.$v[1]);
   }

  $http_status = $respuesta->exito ? 202 : 400;
  header("Content-Type: application/xml; charset=UTF-8", true, $http_status);
  $doc = new DOMDocument('1.0', 'utf-8');
  $doc->formatOutput = true;
  $root = $doc->createElement('alta');
  $root = $doc->appendChild($root);

  $root->appendChild($doc->createElement('exito', ($respuesta->exito ? 'true' : 'false')));
  if($respuesta->exito == false && $respuesta->errores)
   {
	$errores = $doc->createElement('errores');
	$errores = $root->appendChild($errores);
    foreach($respuesta->errores AS $k => $v)
	 {
	  $error = $errores->appendChild($doc->createElement($k));
	  $error->appendChild($doc->createElement('cod', $v));
	  $error->appendChild($doc->createElement('desc', $mensajes['es']['errores'][$v]));
	 }
   }
  elseif($respuesta->exito == true)
   {
	$mensajes[1] = $root->appendChild($doc->createElement('mensajes'));
	$mensajes[1]->appendChild($doc->createElement('cod', 1));
	$mensajes[1]->appendChild($doc->createElement('desc', $mensajes['es']['mensajes'][1]));
   }
  if($respuesta->mensajes)
   {
    foreach($respuesta->mensajes AS $v)
     {
      if($mensajes[$v])
        continue;
	  $mensajes[$v] = $root->appendChild($doc->createElement('mensajes'));
	  $mensajes[$v]->appendChild($doc->createElement('cod', $v));
	  $mensajes[$v]->appendChild($doc->createElement('desc', $mensajes['es']['mensajes'][$v]));
     }
   }
  if(count($_POST))
	$root->appendChild($doc->createElement('ignorados', implode(", ", array_keys($_POST))));
  echo $doc->saveXML();
 }

?>