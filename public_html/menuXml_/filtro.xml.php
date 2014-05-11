<?php

require_once('../../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');
//header('Content-type: text/plain; charset=utf-8');
$doc = new DOMDocument('1.0', 'utf-8');
$doc->formatOutput = true;
$root = $doc->createElement('filtro');
if(!$atributo = $_GET['id']) error("Debe especificar un atributo.");
unset($_GET['id']);
unset($_GET['xml:reqTiempo']);
$root->setAttribute("id", $atributo);

if($path = trim($_SERVER['PATH_INFO'], "/"))
 {
  $path_arr = explode("/", $path);
  $seccion = $path_arr[0];
  $cat = $_GET['cat'];

  if(!empty($path_arr[1]))
   {
   	$leng_cod = $path_arr[1];
   }
  else
   {
   	$leng_cod = "es";
   }
  @include("../../leng/textos.".$leng_cod);
  $bsq[] = "leng_cod = '{$leng_cod}'";

  $mysqli = BaseDatos::Conectar();

  if(!$resultado = $mysqli->query("SELECT * FROM `pub__${seccion}` LIMIT 1")) error("No existe ninguna publicación para la sección indicada.");
  if($finfo = $resultado->fetch_fields())
   {
	$campos = array();
	foreach ($finfo as $val)
	 {
	  $ex = explode("__", $val->name);
	  if($ex[1]) $campos[$ex[1]][$ex[0]] = "{$ex[0]}__{$ex[1]}";
	 }
	$resultado->close();
   }

  //if() error(current($campos[$atributo]));
   
   
   
/* setear atributo etiqueta con la del campo
  $titseccion = $mysqli->query("SELECT sn.titulo, l.id, l.leng_cod FROM admin_secciones ads, secciones_nombres sn, lenguajes l WHERE ads.id = sn.id AND sn.leng_id = l.id AND (l.leng_cod = '${leng_cod}' OR l.leng_poromision = 1) AND ads.identificador = '${seccion}' ORDER BY l.leng_poromision ASC LIMIT 1");
  if($etseccion = $titseccion->fetch_row())
   {
   	$root->setAttribute("etiqueta", $etseccion[0]);
   	$leng_id = $etseccion[1];
   	$leng_cod = $etseccion[2];
   }
*/
  //if($sqlite = new SQLiteDatabase("./${seccion}.sqlite", 0666, $sqlite_error))
  // {
   	//$etseccion = $sqlite->singleQuery("select nombre from seccion where leng_cod = '${leng_cod}'");
   	//$root->setAttribute("etiqueta", $etseccion);
   	
	unset($_GET['cat']);
 	//unset($_GET['leng']);

	if(count($_GET))
	 {
	  $minmax_arr = array('min' => '>=', 'max' => '<=');
	  foreach($_GET AS $params => $params_v)
	   {
	   	if(is_array($params_v))
	   	 {
		  foreach($params_v AS $params_v_k => $params_v_v)
		   {
		   	if(empty($params_v_v)) $bsq[] = current($campos[$params])." {$minmax_arr[$params_v_k]} ${params_v_v}";
		   }
		  continue;
		 }
		if(empty($params_v)) continue;
		$bsq[] = current($campos[$params])." = '".$params_v."'";
	   }
	 }
	 

/*
	if(count($cotejar))
	 {
	  foreach($cotejar AS $params => $params_v)
	   {
		$bsq[] = "string__${params} = '${params_v}'";
	   }
	 }
*/
	$desde = ($pagina-1)*$a;
	if(is_array($bsq)) $bsq = "WHERE ".implode(" AND ", $bsq);

	if($cat)
	 {
	  $tabla_cats = ", items_a_categorias iac";
	  $bsq .= " AND i.id = iac.item_id AND iac.categoria_id = ${cat}";
	 }

//	$total = $mysqli->query("SELECT i.id FROM `pub__${seccion}` i${tabla_cats} ${bsq} GROUP BY id");
//	$total = $total->num_rows;


$consulta = "SELECT DISTINCT ".implode(", ", $campos[$atributo])." FROM `pub__${seccion}` i${tabla_cats} ${bsq} ORDER BY ".end($campos[$atributo]);
//echo "\n{$consulta}\n";
	if(!$resultado = $mysqli->query($consulta)) error($consulta);
	if($total->num_rows > 100) error("El total de opciones es superior a 100.");
	if($fila = $resultado->fetch_row())
	 {
	  $item = $doc->createElement("opcion");
	  $item->setAttribute("xml:id", "");
	  $item->appendChild($doc->createTextNode("Todos"));
	  $item = $root->appendChild($item);
	  do
	   {
	   	if(empty($fila[0])) continue;
		$item = $doc->createElement("opcion");
		$item->setAttribute("xml:id", $fila[0]);
		$item->appendChild($doc->createTextNode(end($fila)));
		$item = $root->appendChild($item);
	   }while($fila = $resultado->fetch_row());
	 }
  // }
 }

$root = $doc->appendChild($root);
echo $doc->saveXML();

function error($error = "Ha ocurrido un error inesperado.")
 {
  global $doc;
  //header("HTTP/1.0 404 Not Found");
  $root = $doc->createElement('error');
  $root->appendChild($doc->createTextNode($error));
  $root = $doc->appendChild($root);
  echo $doc->saveXML();
  exit;
 }

?>