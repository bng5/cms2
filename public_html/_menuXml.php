<?php
/* 

atributos.xml.php
carrito.xml.php
categorias.xml.php
filtro.xml.php
idiomas.xml
imagen.php
items.xml.php
login.xml.php
recuperarclave.php
secciones.xml.{leng}
*/

include('../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');
print_r($_SERVER);

$doc = new DOMDocument('1.0', 'utf-8');
//$doc->formatOutput = true;
//$doc->appendChild(new DOMProcessingInstruction('xsl-stylesheet', 'type="text/xsl" href="/xsl/items.xsl"'));

//$path = explode("/", trim($_SERVER['PATH_INFO'], "/ "));
$path = trim($_SERVER['ORIG_PATH_INFO'], "/ ");
//$accion = $path[0];
/*
print_r(explode("/", $path));
echo "
";
*/
preg_match('/(\w*)(.xml\.?(\w*))?/', $path, $coincidencias);
list($ruta, $modulo, $ext, $leng_cod) = $coincidencias;
/*
    [0] => idiomas.xml.es
    [1] => idiomas
    [2] => .xml.es
    [3] => es
*/

//print_r($coincidencias);

$mysqli = BaseDatos::Conectar();


if($modulo == 'items') {
	$xml = $doc->appendChild($doc->createElement('xml'));
	if($path = trim($_SERVER['PATH_INFO'], "/")) {
		$path_arr = explode("/", $path);
		$seccion = $path_arr[1];
	}
	else
		error("Debe especificar una sección");
	
	//$seccion_id = Seccion::identificador_a_id($seccion);

	$permiso_seccion = $mysqli->query("SELECT id, salida_sitio FROM secciones WHERE identificador = '".$mysqli->real_escape_string($seccion)."'");
	if($permiso_min_fila = $permiso_seccion->fetch_row()) {
		$seccion_id = $permiso_min_fila[0];
		$permiso_min = $permiso_min_fila[1];
	}
	
	//require('../inc/sesiones.php');
	unset($_GET['sesion']);
	//header('Content-type: text/plain; charset=utf-8');

	$root = $doc->createElement('items');

	if($seccion) {
		$cat = $_GET['cat'];
		if(!empty($path_arr[2])) {
			$leng_cod = $path_arr[2];
		}
		else {
			$leng_cod = "es";
		}
		@include("../leng/textos.".$leng_cod);
		$bsq[] = "leng_cod = '{$leng_cod}'";

		if(!$resultado = $mysqli->query("SELECT * FROM `pub__{$seccion_id}` LIMIT 1"))
			error("No existe ninguna publicación para la sección indicada.");
		if($finfo = $resultado->fetch_fields()) {
			$campos = array();
			foreach ($finfo as $val) {
				$ex = explode("__", $val->name);
				if($ex[1])
					$campos[$ex[1]][$ex[0]] = "{$ex[0]}__{$ex[1]}";
			}
			$resultado->close();
		}

		$campos[1] = array('id');
		$campos[2] = array('creado');
		$campos[3] = array('modificado');

		$titseccion = $mysqli->query("SELECT sn.titulo, l.id, l.codigo FROM secciones_nombres sn, lenguajes l WHERE sn.leng_id = l.id AND (l.codigo = '{$leng_cod}' OR l.leng_poromision = 1) AND sn.id = '{$seccion_id}' ORDER BY l.leng_poromision ASC LIMIT 1");
		if($etseccion = $titseccion->fetch_row()) {
			$root->setAttribute("etiqueta", $etseccion[0]);
			$leng_id = $etseccion[1];
			$leng_cod = $etseccion[2];
		}

		$pagina = is_numeric($_GET["xml:pagina"]) ? floor($_GET["xml:pagina"]) : 1;
		$a = is_numeric($_GET["xml:rpp"]) ? floor($_GET["xml:rpp"]): 25;
		if(!$orden_aleat = $_GET['xml:ordenAleat']) {
			$orden = $campos[$_GET['xml:orden']] ? current($campos[$_GET['xml:orden']]) : 'orden';
			$orden_dir = $_GET['xml:orden_dir'] ? 'DESC' : 'ASC';
		}
		else
			$orden = 'orden';

		if(is_string($cat) && $_GET['xml:recursivo']) {
			if(!$rec_cat = $mysqli->query("SELECT id, superior FROM pubcats__{$seccion} WHERE leng_cod = '{$leng_cod}' ORDER BY superior"))
				error("No se encontró ningúna categoría.");
			if($filarec_cat = $rec_cat->fetch_row()) {
				//$cat[] = $cat;
				//$cat_r[] = ;
				$cat = array($cat);
				do {
					if(in_array($filarec_cat[1], $cat)) {
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
		if(count($_GET)) {
			$minmax_arr = array('min' => '>=', 'max' => '<=');
			foreach($_GET AS $params => $params_v) {
				if(is_array($params_v)) {
					//$bsq_arr = array();
					foreach($params_v AS $params_v_k => $params_v_v)
						$bsq[] = current($campos[$params])." {$minmax_arr[$params_v_k]} {$params_v_v}";
					continue;
				}
				if(empty($params_v))
					continue;
				$bsq[] = current($campos[$params])." = '".$params_v."'";//substr($params_v, $pos);
			}
		}
		$desde = ($pagina-1)*$a;
		if(is_array($bsq))
			$bsq = "WHERE ".implode(" AND ", $bsq);

		if(is_array($cat)) {
			if(count($cat)) {
				$orden_prov = "iac";
				$tabla_cats = ", items_a_categorias iac";
				$bsq .= " AND i.id = iac.item_id AND (iac.categoria_id = ".implode(" OR iac.categoria_id = ", $cat).")";
			}
		}
		elseif($cat) {
			$orden_prov = "iac";
			$tabla_cats = ", items_a_categorias iac";
			$bsq .= " AND i.id = iac.item_id AND iac.categoria_id = {$cat}";
		}
		else
			$orden_prov = "i";
		if($orden != 'orden')
			$orden_prov = "i";
		//$total = @$sqlite->query("SELECT id FROM ver_{$seccion}{$leng_vista} {$bsq}", SQLITE_ROW);
		$total = $mysqli->query("SELECT i.id FROM `pub__{$seccion_id}` i{$tabla_cats} {$bsq} GROUP BY id");
		//$total = $total->numRows();
		$total = $total->num_rows;
		$paginas = ceil($total/$a);
		if($pagina > $paginas)
			$pagina = $paginas;
		$root->setAttribute("total", $total);
		$root->setAttribute("rpp", $a);
		$root->setAttribute("pagina", $pagina);
		$root->setAttribute("paginas", $paginas);
		$valores = array();

		$orden_crit = $orden_aleat ? 'RAND()' : "ordennull ASC, {$orden_prov}.{$orden} {$orden_dir}";
		if(!$resultado = $mysqli->query("SELECT i.*, {$orden_prov}.{$orden} IS NULL AS ordennull FROM `pub__{$seccion_id}` i{$tabla_cats} {$bsq} ORDER BY {$orden_crit} LIMIT {$desde}, {$a}"))
			error("Error en consulta.");
		if($fila = $resultado->fetch_assoc()) {
			$tipos = array('string' => 'texto', 'num' => 'texto', 'text' => 'areadetexto', 'int' => 'entero', 'link' => 'enlace');
			do {
				$id = array_shift($fila);
				$item = $doc->createElement("item");
				$item->setAttribute("xml:id", $id);
				$fila = array_slice($fila, 4);
				array_pop($fila);
				foreach($fila AS $k => $v) {
					if(empty($v))
						continue;
					$k = explode("__", $k);
					if($k[0] == "int" || $k[0] == "num" || $k[0] == "date") {
						$valores[$k[1]] = $v;
						continue;
					}
					elseif($k[0] == "img") {
						$dato = $doc->createElement("imagen");
						$v = unserialize($v);
						$dato->setAttribute("archivo", "img/0/{$v[0]}/".urlencode($v[1]));
						$dato->setAttribute("mime", $v[2]);
						$dato->setAttribute("peso", $v[3]);
						$dato->setAttribute("ancho", $v[4]);
						$dato->setAttribute("alto", $v[5]);
						$dato->setAttribute("miniatura", "img/1/{$v[0]}/".urlencode($v[1]));
						$dato->setAttribute("ancho_m", $v[6]);
						$dato->setAttribute("alto_m", $v[7]);
						$dato->setAttribute("peso_m", $v[8]);
					}
					elseif($k[0] == "arch") {
						$dato = $doc->createElement("archivo");
						$v = unserialize($v);
						$dato->setAttribute("archivo", "archivos/".$v[0]);
						$dato->setAttribute("mime", $v[1]);
						$dato->setAttribute("peso", $v[2]);
					}
					else {
						$dato = $doc->createElement("dato");
						if($k[0] == "date" && !empty($v))
							$v = formato_fecha($v, true, false);
						elseif($k[0] == "datetime" && !empty($v))
							$v = formato_fecha($v, true);
						$dato->appendChild($doc->createTextNode(str_replace("\r", "", $v)));
						$dato->setAttribute("tipo", $tipos[$k[0]]);
						if($valores[$k[1]]) {
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
	$root = $xml->appendChild($root);
	exit($doc->saveXML());
}
// Fin Items



if($modulo == 'secciones') {

	$lengIdConsulta = $mysqli->query("SELECT id FROM lenguajes WHERE codigo = '{$leng_cod}' OR leng_poromision = 1 ORDER BY leng_poromision ASC LIMIT 1");
    if($lengId = $lengIdConsulta->fetch_row()) {
		$leng_id = $lengId[0];
		$lengIdConsulta->close();
	}

  try
   {
	$secciones = Secciones::Listado($leng_id, array('sistema' => 0, 'menu' => 1));
   }
  catch(Exception $e)
   {
	error($e->getMessage(), $e->getCode());
	exit($doc->saveXML());
   }
  $root = $doc->appendChild($doc->createElement('secciones'));
  $root->setAttribute("xml:leng", $leng_cod);
  $arbol = new XML_Arbol($root);
  $arbol->RegistrarHandler(new XML_Secciones($doc));
  if($secciones->total) {
	  $iterador = $secciones->getIterator();
	  foreach($iterador AS $seccion) {
		  $arbol->agregar($seccion, $seccion->id, $seccion->superior_id);
	  }
  }
  exit($doc->saveXML());
 }


if($modulo == 'idiomas')
 {
  $xml = $doc->appendChild($doc->createElement('xml'));
  try
   {
	$idiomas = Listado::Idiomas(1, true);
   }
  catch(Exception $e)
   {
	error($e->getMessage(), $e->getCode());
	exit($doc->saveXML());
   }
  $root = $xml->appendChild($doc->createElement('items'));
  foreach($idiomas AS $idioma)
   {
	$item = $root->appendChild($doc->createElement('item'));
	$item->setAttribute("xml:id", $idioma->codigo);
	if($idioma->poromision)
	  $item->setAttribute("poromision", "1");
	$dato = $item->appendChild($doc->createElement('dato', $idioma->nombre_nativo));
	$dato->setAttribute('id', 'etiqueta');
	$dato = $item->appendChild($doc->createElement('dato', $idioma->dir));
	$dato->setAttribute('id', 'dir');
   }
  exit($doc->saveXML());
 }



function error($desc = "Ha ocurrido un error inesperado.", $cod = false)
 {
  global $doc;
  $xml = $doc->appendChild($doc->createElement('xml'));
  header("HTTP/1.1 500 Internal Server Error");
  $root = $xml->appendChild($doc->createElement('error'));
  if($cod)
    $root->appendChild($doc->createElement('codigo', $cod));
  $root->appendChild($doc->createElement('descripcion', $desc));
  exit($doc->saveXML());
 }

?>