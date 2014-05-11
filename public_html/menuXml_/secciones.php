<?php

require_once('../../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');
$doc = new DOMDocument('1.0', 'utf-8');
//$doc->formatOutput = true;
//$doc->appendChild(new DOMProcessingInstruction('xsl-stylesheet', 'type="text/xsl" href="/xsl/items.xsl"'));

$root0 = $doc->createElement('xml');
$root0 = $doc->appendChild($root0);
if($path = trim($_SERVER['PATH_INFO'], "/"))
 {
  $path_arr = explode("/", $path);
  $seccion = $path_arr[0];
 }
else error("Debe especificar una sección");

$mysqli = BaseDatos::Conectar();
$permiso_seccion = $mysqli->query("SELECT s.permiso_min FROM secciones s JOIN admin_secciones ads ON s.id = ads.id WHERE ads.identificador = '${seccion}'");
if($permiso_min_fila = $permiso_seccion->fetch_row())
  $permiso_min = $permiso_min_fila[0];

require('../../inc/sesiones.php');
unset($_GET['sesion']);
//header('Content-type: text/plain; charset=utf-8');

$root = $doc->createElement('items');

if($seccion)
 {
  //$path_arr = explode("/", $path);
  //$seccion = $path_arr[0];
  //$leng = $path_arr[1] ? $path_arr[1] : "es";

  $cat = $_GET['cat'];
  @include("../../leng/textos.".$path_arr[1]);
  if(!empty($path_arr[1]))
   {
   	$leng_cod = $path_arr[1];
   }
  else
   {
   	$leng_cod = "es";
   }
  $bsq[] = "leng_cod = '{$leng_cod}'";



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

  $campos[1] = array('id');
  $campos[2] = array('creado');
  $campos[3] = array('modificado');

  $titseccion = $mysqli->query("SELECT sn.titulo, l.id, l.leng_cod FROM admin_secciones ads, secciones_nombres sn, lenguajes l WHERE ads.id = sn.id AND sn.leng_id = l.id AND (l.leng_cod = '${leng_cod}' OR l.leng_poromision = 1) AND ads.identificador = '${seccion}' ORDER BY l.leng_poromision ASC LIMIT 1");
  if($etseccion = $titseccion->fetch_row())
   {
   	$root->setAttribute("etiqueta", $etseccion[0]);
   	$leng_id = $etseccion[1];
   	$leng_cod = $etseccion[2];
   }
  //if($sqlite = new SQLiteDatabase("./${seccion}.sqlite", 0666, $sqlite_error))
  // {
   	//$etseccion = $sqlite->singleQuery("select nombre from seccion where leng_cod = '${leng_cod}'");
   	//$root->setAttribute("etiqueta", $etseccion);

	$pagina = is_numeric($_GET["xml:pagina"]) ? floor($_GET["xml:pagina"]) : 1;
	$a = is_numeric($_GET["xml:rpp"]) ? floor($_GET["xml:rpp"]): 25;
	if(!$orden_aleat = $_GET['xml:ordenAleat'])
	 {
	  $orden = $campos[$_GET['xml:orden']] ? current($campos[$_GET['xml:orden']]) : 'orden';
	  $orden_dir = $_GET['xml:orden_dir'] ? 'DESC' : 'ASC';
	 }
	else $orden = 'orden';

	if(is_string($cat) && $_GET['xml:recursivo'])
	 {
	  if(!$rec_cat = $mysqli->query("SELECT id, superior FROM pubcats__${seccion} WHERE leng_cod = '${leng_cod}' ORDER BY superior")) error("No se encontró ningúna categoría.");
	  if($filarec_cat = $rec_cat->fetch_row())
	   {
	   	//$cat[] = $cat;
	   	//$cat_r[] = ;
	   	$cat = array($cat);
		do
		 {
		  if(in_array($filarec_cat[1], $cat))
		   {
		   	//$cat_r[] = $filarec_cat[0];
			$cat[] = $filarec_cat[0];
		   }
		 }while($filarec_cat = $rec_cat->fetch_row());
	   }
	 }

	unset($_GET['cat']);
	unset($_GET['xml:pagina']);
	unset($_GET['xml:rpp']);
	unset($_GET['xml:buscar']);
	unset($_GET['xml:ordenAleat']);
	unset($_GET['xml:orden']);
	unset($_GET['xml:orden_dir']);
	unset($_GET['xml:reqTiempo']);
	unset($_GET['xml:recursivo']);
	//$cotejar = $_GET['cotejar'];
	//unset($_GET['cotejar']);
	if(count($_GET))
	 {
	  $minmax_arr = array('min' => '>=', 'max' => '<=');
	  foreach($_GET AS $params => $params_v)
	   {
	   	if(is_array($params_v))
	   	 {
	   	  //$bsq_arr = array();
		  foreach($params_v AS $params_v_k => $params_v_v)
			$bsq[] = current($campos[$params])." {$minmax_arr[$params_v_k]} ${params_v_v}";
		  continue;
		 }
		if(empty($params_v)) continue;
		$bsq[] = current($campos[$params])." = '".$params_v."'";//substr($params_v, $pos);
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


	if(is_array($cat))
	 {
	  if(count($cat))
	   {
		$orden_prov = "iac";
		$tabla_cats = ", items_a_categorias iac";
		$bsq .= " AND i.id = iac.item_id AND (iac.categoria_id = ".implode(" OR iac.categoria_id = ", $cat).")";
	   }
	 }
	elseif($cat)
	 {
	  $orden_prov = "iac";
	  $tabla_cats = ", items_a_categorias iac";
	  $bsq .= " AND i.id = iac.item_id AND iac.categoria_id = ${cat}";
	 }
	else
	  $orden_prov = "i";
	if($orden != 'orden') $orden_prov = "i";
	//$total = @$sqlite->query("SELECT id FROM ver_${seccion}${leng_vista} ${bsq}", SQLITE_ROW);
	$total = $mysqli->query("SELECT i.id FROM `pub__${seccion}` i${tabla_cats} ${bsq} GROUP BY id");
	//$total = $total->numRows();
	$total = $total->num_rows;
	$paginas = ceil($total/$a);
	if($pagina > $paginas) $pagina = $paginas;
	$root->setAttribute("total", $total);
	$root->setAttribute("rpp", $a);
	$root->setAttribute("pagina", $pagina);
	$root->setAttribute("paginas", $paginas);
	$valores = array();
	//if($resultado = $sqlite->unbufferedQuery("SELECT * FROM ver_${seccion}${leng_vista} ${bsq} LIMIT ${desde}, ${a}", SQLITE_ROW))
	//if($total > 0)
	// {
	$orden_crit = $orden_aleat ? 'RAND()' : "ordennull ASC, ${orden_prov}.${orden} ${orden_dir}";
	if(!$resultado = $mysqli->query("SELECT i.*, ${orden_prov}.${orden} IS NULL AS ordennull FROM `pub__${seccion}` i${tabla_cats} ${bsq} ORDER BY ${orden_crit} LIMIT ${desde}, ${a}")) error("Error en consulta.");
	if($fila = $resultado->fetch_assoc())
	 {
	  $tipos = array('string' => 'texto', 'num' => 'texto', 'text' => 'areadetexto', 'int' => 'entero', 'link' => 'enlace');
	  do
	   {
	   	$id = array_shift($fila);
		$item = $doc->createElement("item");
		$item->setAttribute("xml:id", $id);
		$fila = array_slice($fila, 4);
		array_pop($fila);
		foreach($fila AS $k => $v)
		 {
		  if(empty($v)) continue;
		  $k = explode("__", $k);
		  if($k[0] == "int" || $k[0] == "num" || $k[0] == "date")
		   {
		   	$valores[$k[1]] = $v;
		   	continue;
		   }
		  elseif($k[0] == "img")
		   {
			$dato = $doc->createElement("imagen");
			$v = explode(",", $v);
			$dato->setAttribute("archivo", "img/0/{$v[0]}");
			$dato->setAttribute("mime", $v[1]);
			$dato->setAttribute("peso", $v[2]);
			$dato->setAttribute("ancho", $v[3]);
			$dato->setAttribute("alto", $v[4]);
			$dato->setAttribute("miniatura", "img/1/{$v[0]}");
			$dato->setAttribute("ancho_m", $v[5]);
			$dato->setAttribute("alto_m", $v[6]);
			$dato->setAttribute("peso_m", $v[7]);
		   }
		  elseif($k[0] == "arch")
		   {
			$dato = $doc->createElement("archivo");
			$v = explode(",", $v);
			$dato->setAttribute("archivo", "archivos/".$v[0]);
			$dato->setAttribute("mime", $v[1]);
			$dato->setAttribute("peso", $v[2]);
		   }
		  else
		   {
			$dato = $doc->createElement("dato");
			if($k[0] == "date" && !empty($v)) $v = formato_fecha($v, true, false);
			elseif($k[0] == "datetime" && !empty($v)) $v = formato_fecha($v, true);
			$dato->appendChild($doc->createTextNode(str_replace("\r", "", $v)));
			$dato->setAttribute("tipo", $tipos[$k[0]]);
			if($valores[$k[1]])
			 {
			  $dato->setAttribute("valor", $valores[$k[1]]);
			  unset($valores[$k[1]]);
			 }
		   }
		  $dato->setAttribute("id", $k[1]);
		  $dato = $item->appendChild($dato);
		 }
		$item = $root->appendChild($item);
	   }while($fila = $resultado->fetch_assoc());
	 }
 }
  // }

$root = $root0->appendChild($root);
echo $doc->saveXML();

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