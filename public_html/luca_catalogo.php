<?php

require('../inc/iniciar.php');

$path = trim($_SERVER['PATH_INFO'], " /");
include('./inc_xhtml/idiomas.php');
$leng_cod = $idiomas[$path] ? $path : $poromision;
$categoria = $_GET['cat'];
$pagina = $_GET['pagina'];

// Categorias
// /json/lorenzini/categorias?leng=es

//$db = DB::instancia();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="<?= $leng_cod ?>" lang="<?= $leng_cod ?>">
<head>
 <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
 <title><?= SITIO_TITULO ?></title>
 <script type="text/javascript">
 var lengCod = '<?= $leng_cod ?>';
 </script>
 <script type="text/javascript" src="/js/base.js" charset="UTF-8"></script>
 <script type="text/javascript" src="/js/lorenzini/textos.js" charset="UTF-8"></script>
 <script type="text/javascript" src="/js/paginado.js" charset="UTF-8"></script>
 <script type="text/javascript" src="/js/lorenzini/carrito.js" charset="UTF-8"></script>
 <script type="text/javascript" src="/json/lorenzini/categorias?leng=<?= $leng_cod ?>" charset="UTF-8"></script>
 <link rel="stylesheet" type="text/css" href="/css/lorenzini/carrito.css" />
 <!--[if IE]>
   <link rel="stylesheet" type="text/css" media="screen" href="/css/lorenzini/aberraciones_ie.css" />
 <![endif]-->
</head>
<body onload="iniciarCarro()">
 <div id="contenedor">
   <div id="cabezal"><h1><?= SITIO_TITULO ?></h1></div>
   <div id="documento">
     <ul id="navegacion"><li class="activo"><a id="explorar_cats" onclick="tipoNavegacion(this.parentNode.parentNode, 0)"> </a>
         <div id="porcategorias">
		   <span><select name="cat[0]" id="cat_0" onchange="actSelEstilo(this);cargaSubcategorias(this.options[this.selectedIndex].value)"><option value="0">&nbsp;</option></select></span>
	       <span><select name="cat[1]" id="cat_1" onchange="actSelEstilo(this);cargaSubcategoria(this.options[this.selectedIndex].value)"><option>&nbsp;</option></select></span>
         </div>
       </li><li><a id="buscar_codigo" onclick="tipoNavegacion(this.parentNode.parentNode, 1)"> </a>
         <div id="porcodigo">
		   <label for="codigo" id="label_codigo"> </label> <input type="text" name="codigo" id="codigo" onkeyup="cargaCodigo(this.value)" />
         </div>
       </li></ul>
     <div id="navegacion_sep"></div>
     <div id="catalogo">
     </div>
     <div id="paginado"></div>
   </div>
 </div>
 <div id="carro"><div id="carro_titulo"><em onclick="carrito.visibildad(this)"> </em> <span id="carro_total_items"> </span></div><div id="carro_contenido"><div id="total" class="total"><label> </label> <span id="carro_total"> </span> <button onclick="carrito.enviar()" disabled="disabled" id="carro_enviar"><span> </span></button></div></div></div>
</body>
</html>