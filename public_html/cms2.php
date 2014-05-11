<?php

/*
require('../inc/iniciar.php');
@include('./inc_xhtml/idiomas.php');
$sel_idioma = $idiomas[$_GET['leng']] ? $_GET['leng'] : $poromision;
@include('./inc_xhtml/secciones.php');
$sel_seccion = trim($_SERVER['PATH_INFO'], "/");
$rr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if($sel_idioma != $poromision) $p_leng = "leng=${sel_idioma}";
*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS2</title>
<script type="text/javascript">
// <![CDATA[
var SELIDIOMA = <?php echo $_GET['leng'] ? "'{$_GET['leng']}'": "false"; ?>;
var SECCION = <?php echo $_GET['seccion'] ? "'{$_GET['seccion']}'": "false"; ?>;
// ]]>
</script>
<script type="text/javascript" src="/js/cms2.js"></script>
<link type="text/css" rel="stylesheet" media="screen" href="/css/cms2.css" />
</head>
<body>

<!-- div id="cont_reg"></div -->
<div id="estado"></div>
<form action="" style="position:absolute;right:0;" onsubmit="return accederCuenta(this)">
 <fieldset id="login_usuario"><legend onclick="this.parentNode.className = (this.parentNode.className == 'abierto') ? '': 'abierto'">Cuenta de usuario</legend><p id="login_sucesos"> </p><ul>
   <li><label for="acc_usuario">Usuario</label><input type="text" name="usuario" id="acc_usuario" /></li><!-- onblur="habEnvioAcc(this.form)" -->
   <li><label for="acc_clave">Contrase&ntilde;a</label><input type="password" name="clave" id="acc_clave" /></li><!-- onblur="habEnvioAcc(this.form)" -->
   <!-- li><input type="checkbox" name="acc_enviar" id="acc_enviar" onclick="accederCuenta(this.form)" /> <label for="acc_enviar">Enviar datos de acceso con la siguiente petición</label></li -->
   <li><input type="submit" value="Entrar" /></li>
  </ul>
 </fieldset>
</form>
<div id="idiomas"><select><option>No se han cargado idiomas</option></select></div>
<div id="menu"></div>
<h2 id="titulo"></h2>
<fieldset id="info"><legend>Info <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAOCAIAAACU32q7AAAAjklEQVQoka2Ryw3EIAxEnShNUIfrcBtQBm7DtEEbuA0ow3tgxRKIlMvOzaPnz8BhZvCm85UAgGupmfnBsUkxRhFZHDM7l6Za6z7sAoAQwqidc0T0fLiIiEgnEFFV53m/dcw8iJwzAKSUVoiIVLUTrbXbfWbmve9ZSik9znC6bu+EiIgIm77QHHDX8be/+wD99HQ7J6TiVQAAAABJRU5ErkJggg==" onclick="cargarPopup('info')" alt="" /></legend></fieldset>
<fieldset id="categorias"><legend>Categorías</legend></fieldset>
<fieldset id="items"
 ><legend>Items</legend
 ><form action="" name="filtrado"
  ><ul
   ><li><label>Categoría: </label><input type="text" name="cat" size="4" readonly="readonly" /></li
   ><li><label>Recursivo: </label><input type="checkbox" name="xml:recursivo" value="1" onchange="verValores()" /></li
   ><li><label>Resultados: </label><span id="resultados"> </span></li
   ><li><label>Resultados p/página: </label><input type="text" name="xml:rpp" id="rpp" size="2" maxlength="2" /></li
   ><li><label>Orden:</label> <select name="xml:orden" id="orden" onchange="verValores()"><option value="">predeterminado</option></select> <select name="xml:orden_dir" onchange="verValores()"><option value="0">ascendente</option><option value="1">descendente</option></select></li
   ><li><label>Página:</label> <select name="xml:pagina" id="pagina" onchange="verValores()"><option>1</option></select></li
   ><li><label>Buscar:</label> <input type="text" name="xml:buscar" id="buscar" /></li
   ><li id="filtros"><label>Valores distintos:</label></li
   ><li id="extremos"><label>Extremos:</label></li
   ><!-- li><input type="button" value="Actualizar" onclick="verValores()" /></li
  --></ul
 ></form
 ><table border="1" cellspacing="0" cellpadding="4" id="tabla_items"
  ><tr><td></td></tr
 ></table
></fieldset>



</body>
</html>