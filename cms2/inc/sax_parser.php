<?php

function startElement($parser, $name, $attribs)
 {
  if($name == 'XML' || $name == 'ITEM') return;
  global $depth, $niveles, $rutas, $titulo;
  $niveles[$depth[$parser]] = $name;

  echo "\n";

  switch($name)
   {
	case "DATO":
	  if($attribs['TIPO'] == 'areadetexto')
	   {
		$niveles[$depth[$parser]] = 'areadetexto';
		echo "<dl><dt>{$attribs['ETIQUETA']}:</dt><dd>";
	   }
	  else echo "<p><label ".($attribs['ID'] ? " id=\"xml_et_{$attribs['ID']}\"" : "").">{$attribs['ETIQUETA']}:</label> <span>";
	break;
	case "ARCHIVO":
	  echo "<p><label ".($attribs['ID'] ? " id=\"xml_et_{$attribs['ID']}\"" : "").">{$attribs['ETIQUETA']}:</label> <a href=\"/{$attribs['ARCHIVO']}\">".basename($attribs['ARCHIVO'])."</a></p>";
	break;
	case "IMAGEN":
	  if($niveles[$depth[$parser] - 1] == 'IMAGENES') echo "<a href=\"/{$rutas['imagenes']}{$attribs['ARCHIVO']}\"><img src=\"/{$rutas['miniaturas']}{$attribs['ARCHIVO']}\" alt=\"".implode(" ",$titulo)."\" /></a>";
	  else echo "<img src=\"/{$attribs['ARCHIVO']}\" alt=\"".implode(" ",$titulo)."\" />";
	break;
	case "GALERIA":
	  $rutas['imagenes'] = $attribs['IMAGENES'];
	  $rutas['miniaturas'] = $attribs['MINIATURAS'];
	case "AREA":
	  echo "<fieldset><legend>{$attribs['ETIQUETA']}</legend>";
	break;
	case "IMAGENES":
	  echo "<div>";
	break;
	default:
	  echo "<p>{$name}</p>";
	break;
   }
  $depth[$parser]++;
  return;
 }

function endElement($parser, $name)
 {
  global $depth, $niveles;
  //echo "&lt;/<span style=\"color:#0000cc\">$name</span>&gt;";
//echo var_export($niveles, true);
  $finalizando = array_pop($niveles);
  switch($name)
   {
	case "DATO":
	  if($finalizando == 'areadetexto') echo "</dd></dl>";
	  else echo "</span></p>";
	break;
	case "AREA":
	case "GALERIA":
	  echo "\n</fieldset>";
	break;
	case "IMAGENES":
	  echo "</div>";
	break;
   }
  $depth[$parser]--;
 }

function characterData($parser, $data)
 {
  global $niveles, $i_titulo, $titulo;
  if(end($niveles) == 'areadetexto')
   {
	echo nl2br($data);
	return;
   }
  echo $data;
  if(end($niveles) == 'DATO' && $i_titulo == false)
   {
   	array_unshift($titulo, $data);
	$i_titulo = true;
   }
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

?>