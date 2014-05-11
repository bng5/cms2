<?php

require('../inc/iniciar.php');
@include('./inc_xhtml/idiomas.php');
$sel_idioma = $idiomas[$_GET['leng']] ? $_GET['leng'] : $poromision;
@include('./inc_xhtml/secciones.php');
$sel_seccion = trim($_SERVER['PATH_INFO'], "/");
$rr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITIO_TITULO; ?></title>
<script type="text/javascript" src="<?php echo PRINCIPALURL; ?>js/swfobject.js"></script>
<link type="text/css" rel="stylesheet" media="screen" href="<?php echo PRINCIPALURL; ?>css/pagina.css" />
</head>
<body>
<!-- table id="contenedor">
 <tr>
  <td id="contenedorcelda" -->
   <div id="flashcontent3">
    <div id="flashcontent3_alt">
     <h1 id="logo"><?php echo SITIO_TITULO; ?></h1>
     <p id="requerimiento"><!-- Para visualizar este sitio, su navegador debe contar con JavaScript habilitado. --></p>
    </div>
<?php

if($secciones)
 {
  function imprimir_menu($subseccion = false, $nivel = 0)
   {
   	global $secciones, $info, $items, $categorias, $rss, $sel_seccion, $secciones_n, $sel_idioma, $seccion_act_id, $seccion_act;
    if($subseccion == false) $subseccion = current($secciones);
	echo "<ul>";
	foreach($subseccion AS $seccion_k => $seccion_arr)
	 {
	  if($sel_seccion == $seccion_arr['identificador'])
	   {
	   	$seccion_act = $seccion_arr['identificador'];
	   	$seccion_act_id = $seccion_k;
		$info = $seccion_arr['info'];
		$items = $seccion_arr['items'];
		$categorias = $seccion_arr['categorias'];
		$rss = $seccion_arr['rss'];
	   }
	  echo "<li><a href=\"/_index/{$seccion_arr['identificador']}?leng=${sel_idioma}\">{$secciones_n[$seccion_k][$sel_idioma]}</a>";
	    if(is_array($secciones[$seccion_k]))
	     {
	      //array_shift($this->actual_superior);
		  imprimir_menu($secciones[$seccion_k], ++$nivel);
		  $nivel--;
		 }
	  // }
	  //else echo ">{$a['nombre']}</a";
	  echo "</li>";
	 }
	echo "</ul>";
   }

  echo "<div id=\"menu\">";
  $info = 0;
  $items = 0;
  $categorias = 0;
  $rss = 0;
  imprimir_menu();
  echo "</div>\n";
 }

if($seccion_act)
 {
  echo "<div id=\"sec_${seccion_act}\" class=\"contenido_seccion\">\n <h2>{$secciones_n[$seccion_act_id][$sel_idioma]}</h2>";
  if($info)
   {


		$file = "./seccion/${seccion_act}.xml.es";
		$map_array = array(
			"ITEM"     => "div"
		);
		$salto_de_linea = array(
			"DATO" => true
		);

		function startElement($parser, $name, $attrs) 
		 {
		  global $map_array;
		  if (isset($map_array[$name])) {
			echo "<$map_array[$name]>";
		  }
		}

		function endElement($parser, $name) 
		{
			global $map_array;
			if (isset($map_array[$name]))
				echo "</$map_array[$name]>";
		}

		function characterData($parser, $data) 
		{
			echo $data."<br />";
		}

		$xml_parser = xml_parser_create();
		// use case-folding so we are sure to find the tag in $map_array
		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
		xml_set_element_handler($xml_parser, "startElement", "endElement");
		xml_set_character_data_handler($xml_parser, "characterData");
		if(!($fp = @fopen($file, "r"))) {
			echo "No se encontró la información de sección.";
		}
		else
		 {

		while ($data = fread($fp, 4096)) {
			if (!xml_parse($xml_parser, $data, feof($fp))) {
				die(sprintf("XML error: %s at line %d",
							xml_error_string(xml_get_error_code($xml_parser)),
							xml_get_current_line_number($xml_parser)));
			}
		}
		xml_parser_free($xml_parser);
	}


   }

  if($categorias)
   {
	  $cat = $_GET['cat'] ? $_GET['cat'] : 0;
	  $bsq_leng = $_GET['leng'] ? "leng_cod = '{$_GET['leng']}' OR " : false;
	  $mysqli = BaseDatos::Conectar();

	  if(!$consulta_attrs = $mysqli->query("SELECT ic.id, icn.nombre FROM items_categorias ic LEFT JOIN items_categorias_nombres icn ON ic.id = icn.id AND icn.leng_id = 1, admin_secciones ads WHERE ads.id = ic.seccion_id AND ads.identificador = '${seccion}' AND ic.superior = ${cat} ORDER BY ic.orden")) die("<br />\n".__FILE__." ".__LINE__."<br />\n".$mysqli->errno." ".$mysqli->error);
	  if($fila_attrs = $consulta_attrs->fetch_row())
	   {
		$b = 0;
		do
		 {
		  if($fila_attrs[1] == "int")
		   {
			if($b == 0 && $fila_attrs[2] == 2) $hayimg = true;
			else continue;
		   }
		  $attrs_lista[$fila_attrs[0]] = $fila_attrs[3];
		  $b++;
		 }while($fila_attrs = $consulta_attrs->fetch_row());
	   } 

	  $bsq[] = "leng_cod = '{$sel_idioma}'";



	  $pagina = is_numeric($_GET["pagina"]) ? floor($_GET["pagina"]) : 1;
	  $a = is_numeric($_GET["rpp"]) ? floor($_GET["rpp"]): 25;
	  $filtros = $_GET;
	  unset($filtros['cat']);
	  unset($filtros['leng']);
	  unset($filtros['pagina']);
	  unset($filtros['rpp']);
	  if(count($filtros))
	   {
		foreach($filtros AS $params => $params_v)
		 {
		  $bsq[] = "int__${params} = ${params_v}";
		 }
	   }
	  $desde = ($pagina-1)*$a;
	  if(is_array($bsq)) $bsq = "WHERE ".implode(" AND ", $bsq);

	  $total = @$mysqli->query("SELECT id FROM `pubcats__${seccion_act}` WHERE superior = ${cat} AND leng_cod = '${sel_idioma}'");
	  $total = $total->num_rows;
	  $paginas = ceil($total/$a);
	  if($pagina > $paginas) $pagina = $paginas;
		
	  if($consulta = $mysqli->query("SELECT * FROM `pubcats__${seccion_act}` WHERE superior = ${cat} AND leng_cod = '${sel_idioma}' ORDER BY orden LIMIT ${desde}, ${a}"))// echo __LINE__.": ".$mysqli->error;
	   {
		  if($fila = $consulta->fetch_assoc())
		   {
			echo "\n<!-- Categorías -->\n<div id=\"categorias\">\n <ul>";
			do
			 {
			  $id = array_shift($fila);
			  echo "\n  <li><a href=\"${rr}?cat=${id}\"><b>{$fila['titulo']}</b></a></li>";
			 }while($fila = $consulta->fetch_assoc());
			echo "\n </ul>\n</div>";
		   }
	   }
	  else
	   {
		// mysqli->errno 1146 - No existe la tabla
	   }
   }


  if($items)
   {
	$mysqli = BaseDatos::Conectar();
   	
	$pagina = is_numeric($_GET["pagina"]) ? floor($_GET["pagina"]) : 1;
	$a = is_numeric($_GET["rpp"]) ? floor($_GET["rpp"]): 25;
	  $filtros = $_GET;
	  unset($filtros['cat']);
	  unset($filtros['leng']);
	  unset($filtros['pagina']);
	  unset($filtros['rpp']);
	  if(count($filtros))
		 {
		  foreach($filtros AS $params => $params_v)
		   {
			$bsq[] = "int__${params} = ${params_v}";
		   }
		 }
		$desde = ($pagina-1)*$a;
		if(is_array($bsq)) $bsq = "WHERE ".implode(" AND ", $bsq);
		
		if($cat)
		 {
		  $tabla_cats = ", items_a_categorias iac";
		  $bsq .= " AND i.id = iac.item_id AND iac.categoria_id = ${cat}";
		 }
		//$total = @$sqlite->query("SELECT id FROM ver_${seccion}${leng_vista} ${bsq}", SQLITE_ROW);
		$total = $mysqli->query("SELECT i.id FROM `pub__${seccion_act}` i${tabla_cats} ${bsq} GROUP BY id");
		$total = $total->num_rows;
		$paginas = ceil($total/$a);
		if($pagina > $paginas) $pagina = $paginas;

		if($resultado = $mysqli->query("SELECT i.* FROM `pub__${seccion_act}` i${tabla_cats} ${bsq} LIMIT ${desde}, ${a}"))// echo __LINE__.": ".$mysqli->error;
		 {
			if($fila = $resultado->fetch_assoc())
			 {
			  $tipos = array('string' => 'texto', 'date' => 'texto', 'text' => 'areadetexto', 'int' => 'entero');
			  echo "\n<!-- Items -->\n<table>\n <tbody>";
			  do
			   {
				$id = array_shift($fila);
				echo "\n  <tr>";
				$fila = array_slice($fila, 4);
				foreach($fila AS $k => $v)
				 {
				  $k = explode("__", $k);
				  if($k[0] == "int") continue;
				  echo "\n   <td>";
				  if($k[0] == "img")
				   {
					//$dato = $doc->createElement("imagen");
					$v = explode(",", $v);
					echo "<img src=\"/img/imagenesChicas/{$v[0]}\" alt=\"\" />";
					//$dato->setAttribute("archivo", "img/imagenes/".$v[0]);
					//$dato->setAttribute("mime", $v[1]);
					//$dato->setAttribute("peso", $v[2]);
					//$dato->setAttribute("ancho", $v[3]);
					//$dato->setAttribute("alto", $v[4]);
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
					//$dato = $doc->createElement("dato");
					if($k[0] == "date" && !empty($v)) $v = formato_fecha($v, true, false);
					elseif($k[0] == "datetime" && !empty($v)) $v = formato_fecha($v, true);
					echo $v;
					//$dato->appendChild($doc->createTextNode($v));
					//$dato->setAttribute("tipo", $tipos[$k[0]]);
				   }
				  //$dato->setAttribute("id", $k[1]);
				  //$dato = $item->appendChild($dato);
				  echo "</td>";
				 }
				//$item = $root->appendChild($item);
				echo "</tr>";
			   }while($fila = $resultado->fetch_assoc());
			  echo "\n </tbody>\n</table>";
			 }
		}
   }
 
  echo "</div>";
 }

if($idiomas)
 {
echo "
<div id=\"idiomas\"><ul>";
  unset($_GET['leng']);
  $_GET['leng'] = '';
  $rr .= "?".http_build_query($_GET, '', '&amp;');
  //unset($_GET['leng']);
  
  foreach($idiomas AS $leng_cod => $leng)
   {
	echo "<li>";
	echo ($leng_cod == $sel_idioma) ? "<b>${leng}</b>" : "<a href=\"${rr}${leng_cod}\">${leng}</a>";
	echo "</li>";
   }
  echo "</ul></div>";
 }

?>
    <div id="eltorodepicasso"><a href="http://eltorodepicasso.es" target="_blank">eltorodepicasso.es</a></div>
   </div>
  <!-- /td>
  <td width="1"><img src="<?php echo PRINCIPALURL; ?>img/trans" id="img_vert" alt="" /></td>
 </tr>
 <tr>
  <td style="height:1px;"><img src="<?php echo PRINCIPALURL; ?>img/trans" id="img_horiz" alt=""/></td>
  <td></td>
 </tr>
 </table -->
<script type="text/javascript">
// <![CDATA[
document.getElementById('requerimiento').innerHTML = 'Para visualizar este sitio debe contar con FlashPlayer. <a href="http://www.adobe.com/go/getflash">Descargar FlashPlayer.<\/a>';

var fo = new SWFObject("/preload.swf", "pelicula", "100%", "100%", "8");
fo.addParam("scale", "exactfit");
fo.addParam("menu", "false");
//fo.addParam("wmode", "transparent");
fo.write("flashcontent3");

// ]]>
</script>
</body>
</html>