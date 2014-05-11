<?php
header("Content-Type: application/xml; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
if($_GET['modo']== 'xsl')
  echo "<?xml-stylesheet type=\"text/xsl\" href=\"a3.xsl\"?>\n";
?>
<xml xml:lang="es">
<!--
Campo de texto
Área de texto
Número
Color
Precio
Lista de opciones
Fecha y hora
Duración
Enlace externo (dato)
Dato externo

Archivo
Imagen
Galería de imágenes
Enlace

Área
Formulario

Campo de texto
Contraseña
Área de texto
Selector
Selector múltiple

Fuente web
YouTube Video

Contraseña
-->
 <item xml:id="94">
  <titulo atributo="titulo" etiqueta="Título">Gestoría</titulo>
  <texto atributo="titulo2" etiqueta="Título 2">Gestoría 2</texto>
  <texto atributo="titulo3" etiqueta="Título 3">Gestoría 3</texto>
  <areadetexto atributo="descripcion" etiqueta="Descripción">Realización de Tramites y Empadronamientos en Intendencias de Todo el País
Contacto: Virginia Oholeguy Tel. 7099009 Int. 16, Cel. 096 172699</areadetexto>
  <imagen tipo="image/jpeg" peso="20047" ancho="448" alto="248" archivo="http://autosbarriola.com/img/0/6/home_i10.jpg" miniatura="http://autosbarriola.com/img/1/6/home_i10.jpg" ancho_m="109" alto_m="80" peso_m="3038" atributo="foto" etiqueta="Foto Home y Miniatura">
   <texto>Texto alternativo</texto>
   <areadetexto>Descripción larga</areadetexto>
  </imagen>
  <fuente tipo="application/atom+xml" url="http://gdata.youtube.com/feeds/api/videos" />
  <galeria imagenes="img/0/45/" miniaturas="img/1/45/" atributo="imagen" etiqueta="Imagen Auto">
   <imagenes>
    <imagen tipo="image/jpeg" peso="13492" archivo="i10.jpg" ancho="280" alto="203" peso_m="3289" ancho_m="109" alto_m="80"/>
    <imagen tipo="image/jpeg" peso="10076" archivo="i_10.jpg" ancho="280" alto="203" peso_m="2807" ancho_m="109" alto_m="80"/>
    <imagen tipo="image/jpeg" peso="13492" archivo="i10_qq.jpg" ancho="280" alto="203" peso_m="3289" ancho_m="109" alto_m="80"/>
    <imagen tipo="image/jpeg" peso="11526" archivo="i10_vc.JPG.jpg" ancho="280" alto="203" peso_m="2768" ancho_m="109" alto_m="80"/>
    <imagen tipo="image/jpeg" peso="11526" archivo="i10_tt.jpg" ancho="280" alto="203" peso_m="2768" ancho_m="109" alto_m="80"/>
    <imagen tipo="image/jpeg" peso="10777" archivo="hyundai-i10_2008_.jpg" ancho="280" alto="203" peso_m="2799" ancho_m="109" alto_m="80"/>
    <imagen tipo="image/jpeg" peso="13492" archivo="i10_,,.jpg" ancho="280" alto="203" peso_m="3289" ancho_m="109" alto_m="80"/>
    <imagen tipo="image/jpeg" peso="11526" archivo="i10_zz.jpg" ancho="280" alto="203" peso_m="2768" ancho_m="109" alto_m="80"/>
    <imagen tipo="image/jpeg" peso="13492" archivo="i10yfN2Ag.jpg" ancho="280" alto="203" peso_m="3289" ancho_m="109" alto_m="80"/>
   </imagenes>
  </galeria>
  <dato atributo="anyo" tipo="texto" etiqueta="Año">2009</dato>
  <alineacion atributo="colores" tipo="hex" etiqueta="Colores">
   <dato>FFCA2A</dato>
   <dato>FFFFFF</dato>
   <dato>000080</dato>
   <dato>C5C5C5</dato>
   <dato>FF0000</dato>
   <dato>0000D5</dato>
  </alineacion>
  <area atributo="gestoria" etiqueta="Gestoría">
   <texto atributo="titulo" etiqueta="Título">Gestoría</texto>

  </area>
  <area atributo="seguros" etiqueta="Seguros">
   <texto atributo="titulo" etiqueta="Título">Seguros</texto>
   <areadetexto atributo="descripcion" etiqueta="Descripción">Asesoramiento en Costos De Seguros por BSE y Todas Las Compañias Privadas
Contacto: Virginia Oholeguy Tel. 7099009 Int. 16, Cel. 096 172699</areadetexto>
  </area>
 </item>
</xml>