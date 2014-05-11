<?php

include('../../../inc/iniciar.php');
header("Content-Type: application/javascript; charset=UTF-8");
$db = DB::instancia();

$consulta = $db->query("SELECT id, leng_cod FROM `lenguajes` WHERE `leng_habilitado` = 1");
$consulta->setFetchMode(PDO::FETCH_NUM);
$idiomas = array();
foreach($consulta AS $v)
 {
  $idiomas[$v[0]] = $v[1];
 }
unset($consulta);
$consulta = $db->query("(SELECT sv.leng_id, ia.`identificador`, sv.`string` FROM `secciones_valores` sv, items_atributos ia WHERE sv.`item_id` = 22 AND sv.atributo_id = ia.id) UNION (SELECT ian.leng_id, ia.`identificador`, ian.`atributo` FROM `items_secciones_a_atributos` isaa, items_atributos ia JOIN `items_atributos_n` ian ON ia.id = ian.id WHERE isaa.`seccion_id` = 11 AND isaa.atributo_id = ia.id)");
$consulta->setFetchMode(PDO::FETCH_NUM);
$textos = array();
foreach($consulta AS $v)
 {
  if(!$idiomas[$v[0]])
    continue;
  $textos[$idiomas[$v[0]]][$v[1]] = $v[2];
 }

echo 'var Textos = '.json_encode($textos);
/*
var Textos = {}
Textos['es'] = {};
Textos['es']['agCarro'] = 'Agregar al carrito';
Textos['es']['remover'] = 'quitar';
Textos['es']['anterior'] = 'Anterior';
Textos['es']['siguiente'] = 'Siguiente';

Textos['ca'] = {};
Textos['ca']['agCarro'] = 'Agregar al carrito';
Textos['ca']['remover'] = 'quitar';
Textos['ca']['anterior'] = 'Anterior';
Textos['ca']['siguiente'] = 'Siguiente';
 */

?>
