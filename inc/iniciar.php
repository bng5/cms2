<?php

define("SITIO_TITULO", "Suárez &amp; Clavera D'arcy");
define("URL_MAIL", "pablo@bng5.net");
define("PRINCIPALURL", "/");
define("RUTA_CARPETA", "/home/eltorode/public_html/scd");
define("APU", "/");
define("DOMINIO", "scd.eltorodepicasso.es");
define("T_PUBLICACION", "xml");

define("MYSQL_USUARIO", "eltorode_scd");
define("MYSQL_CLAVE", "I?ZBg(F<8H@2");
define("MYSQL_DB", "eltorode_scd");

ini_set("session.gc_maxlifetime", "9000");
session_name("sesion");
session_cache_expire(9000);
if ($_REQUEST['sesion'])
    session_start();
mb_internal_encoding("UTF-8");
error_reporting(E_ALL ^ E_NOTICE);

function __autoload($clase) {
    $clase = str_replace('_', '/', $clase);
    require_once('/home/eltorode/cms2/v2.1/' . $clase . '.php');
}

header("X-Powered-By: Bng5.net");
include('funciones.php');
?>