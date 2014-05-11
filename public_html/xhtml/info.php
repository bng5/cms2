<?php

require('../../inc/iniciar.php');
@include('./../inc_xhtml/idiomas.php');
//@include('../inc_xhtml/secciones.php');
$path = explode("/", trim($_SERVER['PATH_INFO'], "/"));
$sel_seccion = $path[0];
$sel_idioma = $idiomas[$path[1]] ? $path[1] : $poromision;
$rr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if($sel_idioma != $poromision) $p_leng = "leng=${sel_idioma}";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITIO_TITULO; ?></title>
<link type="text/css" rel="stylesheet" media="screen" href="<?php echo PRINCIPALURL; ?>css/info.css" />
</head>
<body id="seccion_<?= $sel_seccion ?>">

<div id="contenido">
 <h1 id="sitio_titulo"><?php echo SITIO_TITULO; ?></h1>
<?php




//if($seccion_act)
// {
  //echo "<div id=\"sec_${seccion_act}\" class=\"contenido_seccion\">\n <h2>{$secciones_n[$seccion_act_id][$sel_idioma]}</h2>";
  $archivo = "../seccion/${sel_seccion}.xml.${sel_idioma}";
  if($archivo)
   {
	$titulo = false;
	$tipo = false;
	$depth = array();

	$map_array = array('ITEM' => 'div', 'DATO' => 'p', 
	  'et_ITEM' => 'h2', 'et_DATO' => 'h3');

	function startElement($parser, $name, $attribs) 
	 {
	  global $depth, $map_array;
	  $et_name = 'et_'.$name;
	  if($attribs['ETIQUETA'] && $map_array[$et_name]) echo "<{$map_array[$et_name]}".($attribs['ID'] ? " id=\"xml_et_{$attribs['ID']}\"" : "").">{$attribs['ETIQUETA']}</{$map_array[$et_name]}>\n";

	  for ($i = 0; $i < $depth[$parser]; $i++)
	   {
        echo "  ";
	   }
	  if(isset($map_array[$name]))
	   { echo "<{$map_array[$name]}".($attribs['ID'] ? " id=\"xml_{$attribs['ID']}\"" : "").($attribs['TIPO'] ? " class=\"{$attribs['TIPO']}\"" : "").">"; }
	  /*
	  echo "&lt;<span style=\"color:#0000cc;\">$name</span>";
	  if(count($attribs))
	   {
		foreach ($attribs as $k => $v)
		 {
		  echo " <span style=\"color:#009900\">$k</span>=\"<span style=\"color:#990000\">$v</span>\"";
         }
       }
      echo "&gt;";
      */
      $depth[$parser]++;
     }

	function endElement($parser, $name) 
	 {
	  global $map_array;
      //echo "&lt;/<span style=\"color:#0000cc\">$name</span>&gt;";
      if(isset($map_array[$name]))
	   { echo "</{$map_array[$name]}>\n"; }
      global $depth;
      $depth[$parser]--;
	 }

	function characterData($parser, $data) 
	 {
      echo $data;
	 }

	function PIHandler($parser, $target, $data) 
	 {
	  switch (strtolower($target))
	   {
		case "php":
			global $parser_file;
            // If the parsed document is "trusted", we say it is safe
            // to execute PHP code inside it.  If not, display the code
            // instead.
        	eval($data);
        	break;
       }
	 }

	function defaultHandler($parser, $data) 
	 {
	  if (substr($data, 0, 1) == "&" && substr($data, -1, 1) == ";")
	   {
        printf('<font color="#aa00aa">%s</font>', 
                htmlspecialchars($data));
	   }
	  else
	   {
        printf('<font size="-1">%s</font>', htmlspecialchars($data));
	   }
	 }

	function new_xml_parser($archivo)
	 {
	  global $parser_file;

      $xml_parser = xml_parser_create("UTF-8");
      xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 1);
      xml_set_element_handler($xml_parser, "startElement", "endElement");
      xml_set_character_data_handler($xml_parser, "characterData");
      xml_set_processing_instruction_handler($xml_parser, "PIHandler");
      //xml_set_default_handler($xml_parser, "defaultHandler");
    
      if (!($fp = @fopen($archivo, "r")))
       {
        return false;
       }
	  if (!is_array($parser_file))
	   {
        settype($parser_file, "array");
       }
      $parser_file[$xml_parser] = $archivo;
      return array($xml_parser, $fp);
	 }

	if (!(list($xml_parser, $fp) = new_xml_parser($archivo)))
	 {
      die("could not open XML input");
	 }

	while ($data = fread($fp, 4096))
	 {
      if (!xml_parse($xml_parser, $data, feof($fp)))
       {
        die(sprintf("XML error: %s at line %d\n", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser)));
	   }
	 }
	xml_parser_free($xml_parser);


//	 }
   }


?>
   </div>
</body>
</html>