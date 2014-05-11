<?php
header("Content-Type: application/xml; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
if($_GET['modo'] == 'xsl')
  echo "<?xml-stylesheet type=\"text/xsl\" href=\"a5.xsl\"?>\n";
elseif($_GET['modo'] == 'css')
  echo "<?xml-stylesheet type=\"text/css\" href=\"/css/xml.css\" ?>\n";
?>
<xml xmlns:xlink="http://www.w3.org/1999/xlink">
<consulta>
 <seccion>Autos 0km</seccion>
</consulta>
<itemsEncabezado>
 <item>
  <atributo identificador="foto">Imagen</atributo>
  <atributo identificador="titulo">Título</atributo>
  <atributo identificador="marca">Marca</atributo>
  <atributo identificador="modelo">Modelo</atributo>
  <atributo identificador="descripcion">Descripción</atributo>
 </item>
</itemsEncabezado>
<itemsLista total="29" rpp="25" pagina="1" paginas="2">
 <item xml:id="94">
  <imagen atributo="foto">
   <uri tipo="image/jpeg" peso="20047" ancho="448" alto="248"
		  xlink:type="simple"
          xlink:href="http://autosbarriola.com/img/0/6/home_i10.jpg">http://autosbarriola.com/img/0/6/home_i10.jpg</uri>
   <uri disp="miniatura" tipo="image/jpeg" peso="3038" ancho="109" alto="80"
		  xlink:type="simple"
          xlink:href="http://autosbarriola.com/img/1/6/home_i10.jpg">http://autosbarriola.com/img/1/6/home_i10.jpg</uri>
   <texto>alt de Hyundai i10</texto>
  </imagen>
  <texto atributo="titulo">i 10, EL PEQUEÑO DE HYUNDAI</texto>
  <texto valor="13" atributo="marca">HYUNDAI</texto>
  <texto atributo="modelo">Hyundai i10</texto>
  <texto atributo="descripcion">HYUNDAI i10 2009, crece a lo ancho hasta los 1.6 metros, aunque mantiene el largo del Atos. El espacio anterior se ha remodelado para que el i10 tenga  5 plazas en lugar de 4. Ofrece unas líneas bastantes similares al compacto i30, con el cual comparte  la parrilla superior.
De manera opcional se podrá incorporar una gran cantidad de elecciones: dirección asistida eléctrica, cierre centralizado, radio CD con MP3  y 6 altavoces, asientos traseros abatibles, techo panorámico, llantas de aleación, entre otros novedosos implementos.</texto>
 </item>
 <item xml:id="114">
  <imagen atributo="foto">
   <archivo tipo="image/jpeg" peso="21584" ancho="448" alto="248">http://autosbarriola.com/img/0/6/Hyundai_Santa_Fe_2416_m2edwW.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" peso="2853" ancho="109" alto="80">http://autosbarriola.com/img/1/6/Hyundai_Santa_Fe_2416_m2edwW.jpg</archivo>
  </imagen>
  <texto atributo="titulo">SANTA FE, GRANDE 4X4 DE HYUNDAI</texto>
  <texto valor="13" atributo="marca">HYUNDAI</texto>
  <texto atributo="modelo">HYUNDAI SANTA FE</texto>
  <texto atributo="descripcion">HYUNDAI SANTA FE 2009, 3 Filas de Asientos, 4x4, Nafta, Extra Full, Doble Airbag, Cuero, Techo, ABS, Climatizador, </texto>
 </item>
 <item xml:id="92">
  <imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="20047" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_legend.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="3038">http://autosbarriola.com/img/1/6/home_legend.jpg</archivo>
  </imagen>
  <texto atributo="titulo">LEGEND DE HONDA</texto>
  <texto valor="12" atributo="marca">HONDA</texto>
  <texto atributo="modelo">LEGEND</texto>
  <texto atributo="descripcion">HONDA LEGEND 2009 El equipamiento de este modelo elementos lleva GPS, tapizado en cuero, techo solar, paquete eléctrico, climatizador automático de dos zonas, asientos eléctricos, llantas de aleación, ESP, ABS, múltiples airbags, control de velocidad, sensor de luces, sensor de parking o cortinilla trasera eléctrica.
La nueva berlina grande de Honda es un vehículo que  en su última generación, se muestra como uno de los automóviles tecnológicamente más avanzados del segmento. Disfruta de un comportamiento excelente gracias a la tracción total.
En carretera, si se desea, el manejo secuencial deja actuar al conductor a su antojo.</texto>
 </item>
 <item xml:id="98">
  <imagen atributo="foto">
   <archivo tipo="image/jpeg" peso="17851" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_civic_si_sedan.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" ancho="109" alto="80" peso="2728">http://autosbarriola.com/img/1/6/home_civic_si_sedan.jpg</archivo>
  </imagen>
  <texto atributo="titulo">CIVIC Si, POTENTE DEPORTIVO</texto>
  <texto valor="12" atributo="marca">HONDA</texto>
  <texto atributo="modelo">CIVIC SI</texto>
  <texto atributo="descripcion">CIVIC SI  2008
Este 0km, agrega al carácter definido del CIVIC una larga lista de innovaciones en tecnología e ingeniería. Resulta un vehículo que va más allá de las fronteras del pensamiento tradicional de autos compactos.</texto>
 </item>
 <item xml:id="103">
  <imagen atributo="foto">
   <archivo tipo="image/jpeg" peso="22246" ancho="448" alto="248">http://autosbarriola.com/img/0/6/fiesta_5ptas.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" ancho="109" alto="80" peso="3172">http://autosbarriola.com/img/1/6/fiesta_5ptas.jpg</archivo>
  </imagen>
  <texto atributo="titulo">FIESTA HATCH, IDEAL PARA CIUDAD</texto>
  <texto valor="4" atributo="marca">FORD</texto>
  <texto atributo="modelo">FIESTA HATCH</texto>
  <texto atributo="descripcion">FORD FIESTA HATCH 2008
Este Sedán 0km de 5 puertas, de 3,908 mts., es el primer modelo realizado por el Sistema de Diseño Global de Ford, (GPDS). Logra una apariencia exterior e interior prácticamente inmejorable.
EQUIPO *A/A,* Direc. *Vidrios,  *CD *Alarma  *Alt. asiento *Espejos</texto>
 </item>
 <item xml:id="7">
  <imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="18871" ancho="448" alto="248">http://autosbarriola.com/img/0/6/photoj1u68s.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2970">http://autosbarriola.com/img/1/6/photoj1u68s.jpg</archivo>
  </imagen>
  <texto atributo="titulo">HONDA CRV, LÍNEAS PERFECTAS</texto>
  <texto valor="12" atributo="marca">HONDA</texto>
  <texto atributo="modelo">CRV</texto>
  <texto atributo="descripcion">HONDA CRV, Modelo 2009, Nafta, 4x2 y 4x4, Full
Garantia 3 Años o 100.000 Km.
En tres versiones:
Honda CRV, 4x2 Full, Doble Airbag
Honda CRV, 4x4 Full, Doble Airbag
Honda CRV, 4x4 Extra Full, Techo, Cuero, 6 Airbag, Control De Tracción</texto>
</item>
<item xml:id="102">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="16336" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_ford_ranger_t_diesel.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2860">http://autosbarriola.com/img/1/6/home_ford_ranger_t_diesel.jpg</archivo>
</imagen>
  <texto atributo="titulo">RANGER NAFTA Y DIESEL</texto>
<texto valor="4" atributo="marca">FORD</texto>
<texto atributo="modelo">RANGER XL T </texto>
<texto atributo="descripcion">FORD RANGER XL T 2008, 4x4, Full, Cuero, Doble Airbag, CD, MP3, BlueTooth y Conexión Ipod
Con gran capacidad de transporte para pasajeros y carga, esta 4x2  reúne los adelantos en equipamiento a la tradición de FORD Ranger.</texto>
</item>
<item xml:id="6">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" peso="20078" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_ford_eco_sportbxcfuX.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" ancho="109" alto="80" peso="2974">http://autosbarriola.com/img/1/6/home_ford_eco_sportbxcfuX.jpg</archivo>
</imagen>
  <texto atributo="titulo">FORD ECO SPORT VERSÁTILY SEGURA</texto>
<texto valor="4" atributo="marca">FORD</texto>
<texto atributo="modelo">FORD ECO SPORT NAFTA 1.6, FULL</texto>
<texto atributo="descripcion">FORD ECO SPORT NAFTA 1.6, MODELO 2009, FULL , 4x2  , Doble Airbag, Vidrios Eléctricos, Bloqueo</texto>
</item>
<item xml:id="106">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="14656" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_ford_fiesta_sedanGk2MIa.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2722">http://autosbarriola.com/img/1/6/home_ford_fiesta_sedanGk2MIa.jpg</archivo>
</imagen>
  <texto atributo="titulo">NUEVO FIESTA SEDAN</texto>
<texto valor="4" atributo="marca">FORD</texto>
<texto atributo="modelo">FIESTA SEDÁN</texto>
<texto atributo="descripcion">FORD FIESTA SEDÁN, MODELO 2009, FULL Y EXTRA FULL
Siempre actual, con nuevos adelantos técnicos, este Sedán satisface las necesidades de un extenso número de usuarios para deplazamientos en ciudad.</texto>
</item>
<item xml:id="96">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="25867" ancho="448" alto="248">http://autosbarriola.com/img/0/6/acccord_hgtf8AAK.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="3515">http://autosbarriola.com/img/1/6/acccord_hgtf8AAK.jpg</archivo>
</imagen>
  <texto atributo="titulo">ACCORD, ELEGANTE Y POTENTE</texto>
<texto valor="12" atributo="marca">HONDA</texto>
<texto atributo="modelo">ACCORD</texto>
<texto atributo="descripcion">SEDÁN ACCORD, MODELO 2009, FULL Y EXTRA FULL
En  sus dos versiones, LX y EX de 4 y 6 cilindros.</texto>
</item>
<item xml:id="88">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" peso="23099" ancho="448" alto="248">http://autosbarriola.com/img/0/6/hyundai_accent_grt01Pju.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" ancho="109" alto="80" peso="3123">http://autosbarriola.com/img/1/6/hyundai_accent_grt01Pju.jpg</archivo>
</imagen>
<texto atributo="titulo">ACCENT, VIAJAR BIEN ACOMPAÑADO</texto>
<texto valor="13" atributo="marca">HYUNDAI</texto>
<texto atributo="modelo">ACCENT Sedán</texto>
<texto atributo="descripcion">HYUNDAI ACCENT SEDÁN, MODELO 2009
Modelos de  2 y 4 Puertas, Full Un auto de dimensiones ciudadanas, ideal para las parejas y familias jóvenes.Con un comportamiento excelente en ruta, es un compañero ideal en época de vacaciones.</texto>
</item>
<item xml:id="108">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="20047" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_i30.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="3038">http://autosbarriola.com/img/1/6/home_i30.jpg</archivo>
</imagen>
  <texto atributo="titulo">i 30, PRÁCTICO DEPORTIVO </texto>
<texto valor="13" atributo="marca">HYUNDAI</texto>
<texto atributo="modelo">I 30</texto>
<texto atributo="descripcion">HYUNDAI I 30, Modelo 2009. Un auto diseñado  para el mercado europeo, con asientos anatómicos y seguros.
Con Control de tracción (TCS) y estabilidad (ESP). Un automóvil que combina la practicidad con la calidad.</texto>
</item>
<item xml:id="97">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="17851" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_civic_sedan.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2728">http://autosbarriola.com/img/1/6/home_civic_sedan.jpg</archivo>
</imagen>
  <texto atributo="titulo">CIVIC, MODERNAS LÍNEAS Y  TECNOLOGÍA</texto>
<texto valor="12" atributo="marca">HONDA</texto>
<texto atributo="modelo">CIVIC LX-S y EX-S</texto>
<texto atributo="descripcion">CIVIC LX-S, Modelo 2009, sedan, con equipamiento completo.
La versión  EX-S añade: el climatizador automático, tapicería de cuero, cargador de seis CD, Radio con mando en el volante, control de crucero y faros antiniebla.</texto>
</item>
<item xml:id="5">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="20513" ancho="448" alto="248">http://autosbarriola.com/img/0/6/DSC02811.JPG.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2990">http://autosbarriola.com/img/1/6/DSC02811.JPG.jpg</archivo>
</imagen>
  <texto atributo="titulo">RANGER NAFTA PICK UP</texto>
<texto valor="4" atributo="marca">FORD</texto>
<texto atributo="modelo">Ranger XL PICK UP   NAFTA</texto>
<texto atributo="descripcion">FORD RANGER XL PICK UP, año 2009 4x2 De líneas clásicas, excelente rendimiento para tareas que requieran traslados en caja. Este modelo trae en la version XL- S, CD con lector de MP3, faros antiniebla, ruedas de 16 pulgadas y paragolpes pintados de color de la carrocería.</texto>
</item>
<item xml:id="99">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="20047" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_pilot.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="3038">http://autosbarriola.com/img/1/6/home_pilot.jpg</archivo>
</imagen>
  <texto atributo="titulo">VEHÍCULO RURAL: ESPACIO, POTENCIA </texto>
<texto valor="12" atributo="marca">HONDA</texto>
<texto atributo="modelo">PILOT</texto>
<texto atributo="descripcion">RURAL PILOT, Modelo 2009, Nafta 4x4, 3 Filas de Asientos
Con lugar para 8 pasajeros se transforma en utilitario con gran capacidad de almacenamiento. Incorpora los adelantos tecnológicos necesarios para estar actualizado, con puerto USB, estructura ACE. Espacio, comodidad, potencia.</texto>
</item>
<item xml:id="100">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="20047" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_odyssey.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="3038">http://autosbarriola.com/img/1/6/home_odyssey.jpg</archivo>
</imagen>
  <texto atributo="titulo">COMODIDAD PARA LA FAMILIA</texto>
<texto valor="12" atributo="marca">HONDA</texto>
<texto atributo="modelo">ODYSSEY RURAL</texto>
<texto atributo="descripcion">ODYSSEY RURAL, Modelo 2009,  De formas aerodínámicas y un interior  con tres filas de asientos ergonómicos y amplios,
Cuenta con un sistema de Control Lógico que selecciona la mejor velocidad. Reúne fuerza, audacia, comodidad y seguridad.
</texto>
</item>
<item xml:id="101">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="18493" ancho="447" alto="248">http://autosbarriola.com/img/0/6/fit_2009..jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2979">http://autosbarriola.com/img/1/6/fit_2009..jpg</archivo>
</imagen>
  <texto atributo="titulo">NUEVO HONDA FIT 2009</texto>
<texto valor="12" atributo="marca">HONDA</texto>
<texto atributo="modelo">FIT</texto>
<texto atributo="descripcion">NUEVO HONDA FIT. MODELO  2009,
Tecnológicamente perfecto. Un auto de dimensiones ciudadanas totalmente apto para la ruta. Con equipamiento opcional que incluye puerto USB.</texto>
</item>
<item xml:id="105">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="14201" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_ford_focus_lxmuiaMT.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2745">http://autosbarriola.com/img/1/6/home_ford_focus_lxmuiaMT.jpg</archivo>
</imagen>
  <texto atributo="titulo">EL FOCUS DE FORD</texto>
<texto valor="4" atributo="marca">FORD</texto>
<texto atributo="modelo">FOCUS LX</texto>
<texto atributo="descripcion">0km FORD FOCUS LX, Año 2009 Siempre actual, gracias a sus líneas y su cuidado diseño.</texto>
</item>
<item xml:id="110">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="17851" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_county_dlx_diesel.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2728">http://autosbarriola.com/img/1/6/home_county_dlx_diesel.jpg</archivo>
</imagen>
  <texto atributo="titulo">PARA EL TRANSPORTE DE PASAJEROS</texto>
<texto valor="13" atributo="marca">HYUNDAI</texto>
<texto atributo="modelo">COUNTY DLX</texto>
<texto atributo="descripcion">HYUNDAI COUNTY DLX, Modelo  2009, Vehículo cómodo, de tamaño ajustado a la ciudad.</texto>
</item>
<item xml:id="115">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="16514" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_tucson_gls.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2850">http://autosbarriola.com/img/1/6/home_tucson_gls.jpg</archivo>
</imagen>
  <texto atributo="titulo">TODOTERRENO DE HYUNDAI </texto>
<texto valor="13" atributo="marca">HYUNDAI</texto>
<texto atributo="modelo">TUCSON GLS</texto>
<texto atributo="descripcion">TUCSON GLS, Modelo 2009, Nafta, Full y Extra Full, Opcional 4x2 y 4x4, Manual y Automática</texto>
</item>
<item xml:id="116">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="16514" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_veracruz.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2850">http://autosbarriola.com/img/1/6/home_veracruz.jpg</archivo>
</imagen>
  <texto atributo="titulo">4X4 DE ALTA PERFORMANCE</texto>
<texto valor="13" atributo="marca">HYUNDAI</texto>
<texto atributo="modelo">VERACRUZ</texto>
<texto atributo="descripcion">HYUNDAI VERACRUZ, Modelo 2009, Con todos los adelantos técnicos, lo reúne todo para sentir la potencia de una gran marca.</texto>
</item>
<item xml:id="150">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" peso="20921" ancho="448" alto="248">http://autosbarriola.com/img/0/6/2008-Ford-Escape.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" ancho="109" alto="80" peso="2926">http://autosbarriola.com/img/1/6/2008-Ford-Escape.jpg</archivo>
</imagen>
  <texto atributo="titulo">CONTUNDENTE</texto>
<texto valor="4" atributo="marca">FORD</texto>
<texto atributo="modelo">ESCAPE</texto>
<texto atributo="descripcion">FORD ESCAPE AMERICANA 2008 Un vehículo para transportar a una familia numerosa.
Cómo, transformable. La calidad de Ford en un modelo moderno y espacioso.</texto>
</item>
<item xml:id="111">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" peso="16336" ancho="448" alto="248">http://autosbarriola.com/img/0/6/home_gran_starex_minibfvamtO.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" ancho="109" alto="80" peso="2860">http://autosbarriola.com/img/1/6/home_gran_starex_minibfvamtO.jpg</archivo>
</imagen>
  <texto atributo="titulo">VEHÍCULO RURAL FULL  PARA 12 PASAJEROS</texto>
<texto valor="13" atributo="marca">HYUNDAI</texto>
<texto atributo="modelo">GRAND STAREX</texto>
<texto atributo="descripcion">HYUNDAI GRAND STAREX, Modelo  2009, Un vehículo estéticamente hermoso que jamás defraudará sus expectativas.</texto>
</item>
<item xml:id="153">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" href="" peso="19386" ancho="448" alto="248">http://autosbarriola.com/img/0/6/hyundai_h1_transporter_2008_.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" href="" ancho="109" alto="80" peso="2941">http://autosbarriola.com/img/1/6/hyundai_h1_transporter_2008_.jpg</archivo>
</imagen>
  <texto atributo="titulo">CÓMODO UTILITARIO</texto>
<texto valor="13" atributo="marca">HYUNDAI</texto>
<texto atributo="modelo">H1 GRAND STAREX  FURGON</texto>
<texto atributo="descripcion">HYUNDAI H1 GRAND STAREX FURGÓN, MODELO 2009,  Nafta y Diesel. Cómodo vehículo para todo tipo de Empresas. </texto>
</item>
<item xml:id="113">
<imagen atributo="foto">
   <archivo tipo="image/jpeg" peso="9342" ancho="289" alto="155">http://autosbarriola.com/img/0/6/foto_hd100.jpg</archivo>
   <archivo disp="miniatura" tipo="image/jpeg" ancho="109" alto="80" peso="3117">http://autosbarriola.com/img/1/6/foto_hd100.jpg</archivo>
</imagen>
  <texto atributo="titulo">EXCELENCIA PARA EL TRABAJO: LEASING</texto>
<texto valor="13" atributo="marca">HYUNDAI</texto>
<texto atributo="modelo">PORTER H100 DIESEL</texto>
<texto atributo="descripcion">HYUNDAI PORTER H100,, Año 2009
Un vehículo para carga, con la oportunidad de ser adquirido mediante leasing. Un auténtico auxiliar en el transporte de carga, ágil, fuerte y de gran practicidad en la conducción.</texto>
</item>
 </itemsLista>
</xml>