<?php

require_once('../../inc/iniciar.php');
header('Content-type: application/xml; charset=utf-8');
//header('Content-type: text/plain; charset=utf-8');
$doc = new DOMDocument('1.0', 'utf-8');
$root0 = $doc->createElement('xml');
$root0 = $doc->appendChild($root0);
$root = $doc->createElement('items');

if($path = trim($_SERVER['PATH_INFO'], "/")) {
    include('../../bng5/datos/secciones.php');

    $path_arr = explode("/", $path);
    $cat = $_GET['cat'] ? $_GET['cat'] : 0;
    $bsq_leng = $path_arr[1] ? "codigo = '{$path_arr[1]}' OR " : false;
    $mysqli = BaseDatos::Conectar();

    if(!$consulta_lengs = $mysqli->query("SELECT id, codigo FROM lenguajes WHERE {$bsq_leng}leng_poromision = 1 AND estado = 1 ORDER BY leng_poromision ASC LIMIT 1"))
        die("<br />\n".__FILE__." ".__LINE__."<br />\n".$mysqli->errno." ".$mysqli->error);
    if($fila_lengs = $consulta_lengs->fetch_row()) {
        $leng_id = $fila_lengs[0];
        $leng_cod = $fila_lengs[1];
    }

    $seccion_id = $secciones_urls[$leng_cod][$path_arr[0]];
    $seccion = $secciones[$seccion_id];

    if(!$consulta_attrs = $mysqli->query("SELECT ic.id, icn.nombre FROM items_categorias ic LEFT JOIN items_categorias_nombres icn ON ic.id = icn.id AND icn.leng_id = 1, secciones ads WHERE ads.id = ic.seccion_id AND ads.id = '".$seccion_id."' AND ic.superior = {$cat} ORDER BY ic.orden"))
        die("<br />\n".__FILE__." ".__LINE__."<br />\n".$mysqli->errno." ".$mysqli->error);
    if($fila_attrs = $consulta_attrs->fetch_row()) {
        $b = 0;
        do {
            if($fila_attrs[1] == "int") {
                if($b == 0 && $fila_attrs[2] == 2)
                    $hayimg = true;
                else
                    continue;
            }
            $attrs_lista[$fila_attrs[0]] = $fila_attrs[3];
            $b++;
        }while($fila_attrs = $consulta_attrs->fetch_row());
    }

    @include("../../leng/textos.".$path_arr[1]);
    if(empty($path_arr[1]))
        $leng_vista = "_leng";
    else {
        $bsq[] = "leng_cod = '{$path_arr[1]}'";
        $leng_cod = $path_arr[1];
    }

    $lengs = $mysqli->query("SELECT id, codigo FROM lenguajes WHERE codigo = '{$path_arr[1]}' OR leng_poromision = 1 ORDER BY leng_poromision ASC LIMIT 1");
    if($leng = $lengs->fetch_row()) {
        $leng_id = $leng[0];
        $leng_cod = $leng[1];
    }


    $cat = $_GET['cat'] ? $_GET['cat'] : 0;

    $pagina = (int) $_GET["xml:pagina"];
    if(!$pagina)
        $pagina = 1;
    $a = (int) $_GET["xml:rpp"];
    if(!$a)
        $a = 25;
/*
  unset($_GET['cat']);
  unset($_GET['leng']);
  unset($_GET['pagina']);
  unset($_GET['rpp']);

  if(count($_GET))
   {
	foreach($_GET AS $params => $params_v)
	 {
	  $bsq[] = "int__{$params} = {$params_v}";
	 }
   }
*/
    $desde = ($pagina-1)*$a;
    if(is_array($bsq))
        $bsq = "WHERE ".implode(" AND ", $bsq);

    $total = @$mysqli->query("SELECT id FROM `pubcats__{$seccion_id}` WHERE superior = {$cat} AND leng_cod = '{$leng_cod}'");
    $total = $total->num_rows ? $total->num_rows : 0;
    $paginas = ceil($total/$a);
    if($pagina > $paginas)
        $pagina = $paginas;
    $root->setAttribute("total", $total);
    $root->setAttribute("superior", $cat);
    $root->setAttribute("rpp", $a);
    $root->setAttribute("pagina", $pagina);
    $root->setAttribute("paginas", $paginas);

    if($_GET['ver'] == 'total') {
        $root = $root0->appendChild($root);
        echo $doc->saveXML();
        exit;
    }

    if($consulta = $mysqli->query("SELECT COUNT(i.`id`), pub.* FROM `pubcats__{$seccion_id}` pub LEFT JOIN (`items_a_categorias` iac LEFT JOIN items i ON iac.item_id = i.id AND i.estado_id = 1) ON pub.id = iac.categoria_id, items_categorias ic WHERE pub.id = ic.id AND pub.superior = {$cat} AND pub.leng_cod = '{$leng_cod}' GROUP BY pub.`id` ORDER BY ic.orden")) {// LIMIT {$desde}, {$a}"))//die(__LINE__." ".$mysqli->error);
        if($fila = $consulta->fetch_assoc()) {
            $tipos = array('string' => 'texto', 'date' => 'texto', 'text' => 'areadetexto', 'int' => 'entero');
            do {
                $tot_items = array_shift($fila);
                $id = array_shift($fila);
                $item = $doc->createElement("item");
                $item->setAttribute("xml:id", $id);
                $item->setAttribute("categoria", $fila['titulo']);
                $item->setAttribute("total_items", $tot_items);

                $categoria = $doc->createElement("dato");
                $categoria->setAttribute("id", "__categoria");
                $categoria->setAttribute("tipo", "texto");
                $categoria->appendChild($doc->createTextNode($fila['titulo']));
                $item->appendChild($categoria);
                //$item->appendChild($doc->createTextNode(var_export($fila, true)));
                $fila = array_slice($fila, 4);
                //$item->appendChild($doc->createTextNode(var_export($fila, true)));

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
                        $v = explode(",", $v);
                        $dato->setAttribute("archivo", "img/0/".$v[0]);
                        $dato->setAttribute("mime", $v[1]);
                        $dato->setAttribute("peso", $v[2]);
                        $dato->setAttribute("ancho", $v[3]);
                        $dato->setAttribute("alto", $v[4]);
                        $dato->setAttribute("miniatura", "img/1/{$v[0]}");
                        $dato->setAttribute("ancho_m", $v[5]);
                        $dato->setAttribute("alto_m", $v[6]);
                        $dato->setAttribute("peso_m", $v[7]);
                    }
                    elseif($k[0] == "arch") {
                        $dato = $doc->createElement("archivo");
                        $v = explode(",", $v);
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
                        $dato->appendChild($doc->createTextNode($v));
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
            }while($fila = $consulta->fetch_assoc());
        }
    }
}

$root = $root0->appendChild($root);
echo $doc->saveXML();

?>