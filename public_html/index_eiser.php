<?php

require('../inc/iniciar.php');
$idiomas = @include('./inc_xhtml/idiomas.php');
$sel_idioma = $_GET['leng'] ? $_GET['leng'] : $_COOKIE['leng'];
$sel_idioma = $idiomas[$sel_idioma] ? $sel_idioma : $poromision;
//header("Content-Language: ".$sel_idioma);

if($_COOKIE['leng'] != $sel_idioma)
  setcookie("leng", $sel_idioma, 0, "/");

$titulo = array(SITIO_TITULO);

//$sel_idioma = $idiomas[$leng_arr[$dom]] ? $leng_arr[$dom] : $poromision;
$secciones = @include('./inc_xhtml/secciones.php');
$sel_seccion = trim($_SERVER['PATH_INFO'], "/");
//$rr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//if($sel_idioma != $poromision)
$p_leng = "leng=${sel_idioma}";
$flashvars = array();
$flashvars['leng'] = $sel_idioma;

$hbq = array('menu' => array(), 'item' => array(), 'cat' => array(), 'paginado' => array());
if($_GET['leng'])
 {
  $hbq['menu']['leng'] = $_GET['leng'];
  $hbq['item']['leng'] = $_GET['leng'];
  $hbq['cat']['leng'] = $_GET['leng'];
  $hbq['paginado']['leng'] = $_GET['leng'];
 }
if($_GET['cat'])
 {
  $hbq['item']['cat'] = $_GET['cat'];
  $hbq['paginado']['cat'] = $_GET['cat'];
 }
if($_GET['pagina'])
 {
  $hbq['item']['pagina'] = $_GET['pagina'];
 }
if($_GET['nav_flash'])
 {
  $hbq['menu']['nav_flash'] = $_GET['nav_flash'];
  $hbq['item']['nav_flash'] = $_GET['nav_flash'];
  $hbq['cat']['nav_flash'] = $_GET['nav_flash'];
  $hbq['paginado']['nav_flash'] = $_GET['nav_flash'];
 }

$hbq_menu = count($hbq['menu']) ? '?'.http_build_query($hbq['menu'], '', '&amp;') : '';
$hbq['item']['id'] = '';
$hbq_item = count($hbq['item']) ? '?'.http_build_query($hbq['item'], '', '&amp;') : '';
$hbq['cat']['cat'] = '';
$hbq_cat = count($hbq['cat']) ? '?'.http_build_query($hbq['cat'], '', '&amp;') : '';
$hbq['paginado']['pagina'] = '';
$hbq_paginado = count($hbq['paginado']) ? '?'.http_build_query($hbq['paginado'], '', '&amp;') : '';


if($secciones)
 {
  ob_start();
  function imprimir_menu($subseccion = false, $nivel = 0)
   {
   	global $secciones, $info, $items, $categorias, $rss, $sel_seccion, $secciones_n, $sel_idioma, $seccion_act_id, $seccion_act, $titulo, $hbq_menu;
    if($subseccion == false) $subseccion = current($secciones);
	$menu .= "<ul>";
	foreach($subseccion AS $seccion_k => $seccion_arr)
	 {
	  $menu .= "<li><a href=\"/index/{$seccion_arr['identificador']}${hbq_menu}\"";
	  if($sel_seccion == $seccion_arr['identificador'])
	   {
	   	$seccion_act = $seccion_arr['identificador'];
	   	$seccion_act_id = $seccion_k;
		$info = $seccion_arr['info'];
		$items = $seccion_arr['items'];
		$categorias = $seccion_arr['categorias'];
		$rss = $seccion_arr['rss'];
		array_unshift($titulo, $secciones_n[$seccion_k][$sel_idioma]);
		$menu .= " class=\"sel_seccion\"";
	   }
	  $menu .= ">{$secciones_n[$seccion_k][$sel_idioma]}</a>";
	  if(is_array($secciones[$seccion_k]))
	   {
		$menu .= imprimir_menu($secciones[$seccion_k], ++$nivel);
		$nivel--;
	   }
	  $menu .= "</li>";
	 }
	return $menu."</ul>";
   }
  $info = 0;
  $items = 0;
  $categorias = 0;
  $rss = 0;
  echo "<div id=\"menu\">".imprimir_menu()."</div>";
  $menu = ob_get_contents();
  ob_end_clean();
 }


if($seccion_act)
 {
  function nav_cat($p_id, $nav_cat)
   {
	global $mysqli, $seccion_act, $cat_cuenta, $sel_idioma;
	$cat_cuenta++;
	if(!$resultcat = $mysqli->query("SELECT c.id, c.superior, cn.nombre FROM items_categorias c LEFT JOIN items_categorias_nombres cn ON c.id = cn.id AND cn.leng_id = 1 WHERE c.id = '${p_id}' LIMIT 1")) die(__LINE__." - ".$mysqli->error);
	if($row_cat = $resultcat->fetch_row())
	 {
	  $nombre = $row_cat[2] ? $row_cat[2] : "id: {$row_cat[0]}";
	  $nav_cat = nav_cat($row_cat[1], $nav_cat)."<a href=\"/index/${seccion_act}?${hbq_cat}{$row_cat[0]}\">{$nombre}</a>&nbsp;&gt;&nbsp;";
	 }
	return $nav_cat;
   }
  $flashvars['seccion'] = $seccion_act;
  ob_start();
  echo "
<div id=\"contenido\" class=\"contenido_seccion\">
 <h2>".current($titulo)."</h2>";
  if(!empty($_GET['id']))
   {
   	$archivo = "./item/{$_GET['id']}.xml.${sel_idioma}";
   	$items = false;
   	$i_titulo = false;

	$cat = $_GET['cat'] ? $_GET['cat'] : false;
	if($cat)
	 {
	  $mysqli = BaseDatos::Conectar();
	  $consulta_cat = $mysqli->query("SELECT * FROM `pubcats__${seccion_act}` WHERE id = ${cat} AND leng_cod = '{$sel_idioma}' LIMIT 1");
	  if($fila_cat = $consulta_cat->fetch_assoc())
	   {
		echo "<div><a href=\"/index/${seccion_act}${hbq_menu}\">".current($titulo)."</a>&nbsp;&gt;&nbsp;".nav_cat($fila_cat['superior'], NULL)."<b><a href=\"/index/${seccion_act}${hbq_item}\">{$fila_cat['titulo']}</a></b></div>";
		array_unshift($titulo, $fila_cat['titulo']);
	   }
	 }
	else echo "<p><a href=\"/index/${seccion_act}${hbq_item}\">Volver</a></p>";
   }
  elseif($info)
   {
   	$archivo = "./seccion/${seccion_act}.xml.${sel_idioma}";
   	$i_titulo = true;
   }
  if($archivo)
   {
	$tipo = false;
	$depth = array();
	$niveles = array();
	$rutas = array();


	include('../cms2/inc/sax_parser.php');


	if(!(list($xml_parser, $fp) = new_xml_parser($archivo)))
	 {
      echo "No se encontró la información requerida.";
	 }
	else
	 {
	  $depth[$xml_parser] = 0;
	  while ($data = fread($fp, 4096))
	   {
        if (!xml_parse($xml_parser, $data, feof($fp)))
         {
          die(sprintf("XML error: %s at line %d\n", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser)));
	     }
	   }
	  xml_parser_free($xml_parser);
	 }
   }


  $cat = false;
  if($items && $categorias)
   {
	$cat = $_GET['cat'] ? $_GET['cat'] : 0;
	//$bsq_leng = "leng_cod = '{$sel_idioma}' OR ";//$_GET['leng'] ? "leng_cod = '{$_GET['leng']}' OR " : false;
	$mysqli = BaseDatos::Conectar();

	if($cat)
	 {
	  $consulta_cat = $mysqli->query("SELECT * FROM `pubcats__${seccion_act}` WHERE id = ${cat} AND leng_cod = '{$sel_idioma}' LIMIT 1");
	  if($fila_cat = $consulta_cat->fetch_assoc()) //if($consulta_cat)
	   {
		echo "<div><a href=\"/index/${seccion_act}${hbq_menu}\">".current($titulo)."</a>&nbsp;&gt;&nbsp;".nav_cat($fila_cat['superior'], NULL)."<b>{$fila_cat['titulo']}</b></div>";
		array_unshift($titulo, $fila_cat['titulo']);

		if($item = array_slice($fila_cat, 5))
		 {
		  echo "<ul>";
		  $j = 0;
		  foreach($item AS $x => $y)
		   {
		   	if(!$y) continue;
		   	$ex = explode("__", $x);
		    echo "<li>";
			switch($ex[0])
			 {
			  case "text":
			  case "string":
				echo $y;
			   break;
			  case "img":
				$v = explode(",", $y);
				echo "<img src=\"/img/1/{$v[0]}\" alt=\"\" />";
			   break;
			  case "arch":
				$v = explode(",", $y);
				echo "<a href=\"/archivos/{$v[0]}\" type=\"{$v[1]}\">{$v[0]}</a>";//implode(" -- ",$v);//"<img src=\"/img/1/{$v[0]}\" alt=\"\" />";
			   break;
			  default:
				echo $y;
			   break;
			 }
			echo "</li>";
		   }
		  echo "</ul>";
		 }
	   }
	  else
	   {
	   	$cat = 0;
	   }
	 }

	if($consulta = $mysqli->query("SELECT id, titulo FROM `pubcats__${seccion_act}` pub WHERE pub.superior = ${cat} AND pub.leng_cod = '{$sel_idioma}' ORDER BY pub.orden"))// echo __LINE__.": ".$mysqli->error;
	 {
	  if($fila_cat = $consulta->fetch_row())
	   {
		echo "\n<!-- Categorías -->\n<div id=\"categorias\">\n <ul>";
		do
		 {
		  echo "\n  <li><a href=\"/index/${seccion_act}${hbq_cat}{$fila_cat[0]}\"><b>{$fila_cat[1]}</b></a></li>";
		 }while($fila_cat = $consulta->fetch_row());
		echo "\n </ul>\n</div>";
	   }
	 }
   }

  if($items)
   {
	$mysqli = BaseDatos::Conectar();
    @include("./inc_xhtml/etiquetas_${seccion_act}.${sel_idioma}.php");
	$pagina = is_numeric($_GET["pagina"]) ? floor($_GET["pagina"]) : 1;
	$a = is_numeric($_GET["rpp"]) ? floor($_GET["rpp"]): 10;
	$filtros = $_GET;

	$campos = array();
	if($resultado = $mysqli->query("SELECT * FROM `pub__${seccion_act}` LIMIT 1"))
	 {
	if($finfo = $resultado->fetch_fields())
	 {
	  foreach ($finfo as $val)
	   {
		$ex = explode("__", $val->name);
		if($ex[1]) $campos[$ex[1]][$ex[0]] = "{$ex[0]}__{$ex[1]}";
	   }
	 }
	 $resultado->close();
	}

	$campos[1] = array('id');
	$campos[2] = array('creado');
	$campos[3] = array('modificado');

	unset($filtros['cat']);
	unset($filtros['leng']);
	unset($filtros['pagina']);
	unset($filtros['rpp']);
	unset($filtros['orden']);
	unset($filtros['orden_dir']);
	unset($filtros['id']);
	unset($filtros['nav_flash']);

	if(count($filtros))
	 {
	  foreach($filtros AS $params => $params_v)
	   {
		if(empty($params_v)) continue;
		$bsq[] = current($campos[$params])." = '".$params_v."'";//substr($params_v, $pos);
	   }
	 }
	$desde = ($pagina-1)*$a;
	if(is_array($bsq)) $bsq = "WHERE ".implode(" AND ", $bsq)." AND";
	else $bsq = "WHERE ";
	if($cat !== false)
	 {
	  $bsq_cat = ($cat == 0) ? 'IS NULL' : '= '.$cat;
	  $tabla_cats = " LEFT JOIN items_a_categorias iac ON i.id = iac.item_id AND iac.categoria_id ${bsq_cat}";
	 }

	if($total_q = $mysqli->query("SELECT count(DISTINCT i.id) FROM `pub__${seccion_act}` i${tabla_cats} ${bsq} 1"))
	  $total_f = $total_q->fetch_row();

	if($total = $total_f[0])
	 {
	  $paginas = ceil($total/$a);
	  if($pagina > $paginas) $pagina = $paginas;
	  if($resultado = $mysqli->query("SELECT i.* FROM `pub__${seccion_act}` i${tabla_cats} ${bsq} leng_cod = '${sel_idioma}' LIMIT ${desde}, ${a}"))// echo __LINE__.": ".$mysqli->error;
	   {
		if($finfo = $resultado->fetch_fields())
		 {
		  $campos = array();
		  foreach($finfo as $val)
	 	   {
	  		$ex = explode("__", $val->name);
	  		if($ex[1]) $campos[$ex[1]][$ex[0]] = $val->name;
	 	   }
		  echo "\n<!-- Items -->\n<table><thead><tr>";
		  $attr_consalida = 1;
		  $atributos = array();
		  foreach($campos AS $k => $v)
		   {
			$filtro = ($v['int'] || $v['string']) ? 1 : 0;
			$max_min = ($v['int'] || $v['num'] || $v['date']) ? 1 : 0;
			if($v['string'] || $v['img'] || $v['text'] || $v['arch'])//$salida)
			 {
			  $attr_consalida++;
			  $atributos[end($v)] = key($v);//$etiquetas[$k];
			  echo "<th>{$etiquetas[$k]}</th>";
			 }
		   }
		  echo "</tr></thead>";

		  if($paginas > 1)
		   {
			echo "<tfoot><tr><td colspan=\"${attr_consalida}\"><p>";
			if($pagina > 1) echo "<a href=\"/index/${seccion_act}${hbq_paginado}".($pagina - 1)."\">Anterior</a> ";
			$p_inicio = ($pagina > 9) ? $pagina-8 : 1;
			$p_fin = ($paginas > $pagina+9) ? $pagina+8 : $paginas;
			for($p = $p_inicio; $p <= $p_fin; $p++)
			  echo ($p == $pagina) ? "<b>${p}</b> " : "<a href=\"/index/${seccion_act}${hbq_paginado}${p}\">${p}</a> ";
			if($pagina < $paginas) echo "<a href=\"/index/${seccion_act}${hbq_paginado}".($pagina + 1)."\">Siguiente</a> ";
			echo "</p></td></tr></tfoot>";
		   }
		  echo "<tbody>";
		 }

		if($item = $resultado->fetch_assoc())
		 {
		  if($p_leng) $p_leng = "&amp;".$p_leng;
		  //$tipos = array('string' => 'texto', 'date' => 'texto', 'text' => 'areadetexto', 'int' => 'entero');
		  do
		   {
		   	$id = array_shift($item);
		   	echo "<tr>";
			$j = 0;
			$linkeado = false;
			foreach($atributos AS $x => $y)
			 {
			  echo "<td>";
			  if(!$linkeado) echo "<a href=\"${rr}${hbq_item}${id}\">";
			  if(!empty($item[$x]))
			   {
				switch($y)
				 {
				  case "text":
					if(mb_strlen($item[$x]) > 40) $item[$x] = rtrim(mb_substr($item[$x], 0, 35))."…";
				  case "string":
					echo htmlspecialchars($item[$x]);
				   break;
				  case "img":
					$v = explode(",", $item[$x]);
					echo "<img src=\"/img/1/{$v[0]}\" alt=\"\" />";
				   break;
				  default:
					echo "[".$item[$x]."]";
				   break;
				 }
			   }
			  if(!$linkeado)
			   {
				echo "</a>";
				$linkeado = true;
			   }
			  echo "</td>";
			 }
			//echo "<td><a href=\"${rr}${hbq_item}${id}\">+info</a></td></tr>";
			echo "</tr>";
		   }while($item = $resultado->fetch_assoc());
		  echo "\n </tbody>\n</table>";
		 }
	   }
	 }
   }
  echo "</div>";
  $seccion = ob_get_contents();
  ob_end_clean();
 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="<?= $sel_idioma ?>" lang="<?= $sel_idioma ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="<?= $sel_idioma ?>" />
<title><?= implode(" - ",$titulo); ?></title>
<?php
@include('./inc_xhtml/meta.php');
 ?>
<!-- link type="text/css" rel="stylesheet" media="screen" href="/css/pagina.css" / -->
<script type="text/javascript" src="/js/swfobject.js"></script>
</head>
<body>
<div id="flashcontent3"><h1 id="logo"><?= array_pop($titulo) ?></h1>
 <div id="flashcontent3_alt"><?= (($meta['descripcion'][$sel_idioma] && !$seccion_act) ? "<p>{$meta['descripcion'][$sel_idioma]}</p>": '') ?>

<?php





//chdir('xhtml');
//include_once('xhtml/encabezado.php');
//chdir('../');




echo $seccion;


echo "<pre>
get
";
print_r($_GET);
echo "\n
cookie
";
print_r($_COOKIE);
echo "\n
request
";
print_r($_REQUEST);
echo "\n
server
";
//print_r($_SERVER);
echo "\n";
echo "</pre>";
if($idiomas && count($idiomas) > 1)
 {
  echo "\n<div id=\"idiomas\"><ul>";
  unset($_GET['leng']);
  $_GET['leng'] = '';
  $rr = "?".http_build_query($_GET, '', '&amp;');
  //unset($_GET['leng']);

  foreach($idiomas AS $leng_cod => $leng)
   {
	echo "<li>";
	echo ($leng_cod == $sel_idioma) ? "<b>${leng['etiqueta']}</b>" : "<a href=\"/index/${seccion_act}${rr}${leng_cod}\" hreflang=\"${leng_cod}\" lang=\"${leng_cod}\" rel=\"alternate\" rev=\"alternate\" dir=\"{$leng['dir']}\">{$leng['etiqueta']}</a>";
	echo "</li>";
   }
  echo "</ul></div>";
 }

?>
 </div>
 <div id="eltorodepicasso"><a href="http://www.eltorodepicasso.es" target="_blank">eltorodepicasso.es</a></div>
</div>

<?php

if($_GET['nav_flash'] != "no")
 {
?>
<iframe name="paral" id="paral" frameborder="0" width="1" height="1" marginheight="0" marginwidth="0" style="display:none;visibility:hidden;"></iframe>

<!-- script type="text/javascript">
// <![CDATA[
//document.getElementById('requerimiento').innerHTML = 'Para visualizar este sitio correctamente su navegador debe contar con el plug-in de Flash.<br \/><a target="_blank" rel="external" href="http://www.adobe.com/go/getflash">Descargar plug-in aqu&iacute;.<\/a>';
var fo = new SWFObject("/preload.swf", "peliculaCentral", "100%", "100%", "8");
<?php
if($_GET['id']) echo "fo.addVariable('id', '{$_GET['id']}');\n";
?>
fo.addVariable("leng", "<?= $sel_idioma ?>");
fo.addVariable("seccion", "<?= $seccion_act ?>");

fo.addParam("scale", "exactfit");
fo.addParam("menu", "false");
fo.addParam("wmode", "transparent");
fo.write("flashcontent3");

// ]]>
</script -->
<?php
}
?>
</body>
</html>