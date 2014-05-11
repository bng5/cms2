
function cargarXml(url, hand, parametros)
 {
  if(window.XMLHttpRequest)
   {
   	var reqTiempo = new Date();
   	url += parametros ? '&': '?';
   	url += 'xml:reqTiempo='+reqTiempo.getTime();
    var req = new XMLHttpRequest();
    req.onreadystatechange = function()
	 {
	  if(req.readyState == 4)
	   {
		eval(hand+"(req)");
	   }
	 }
    req.open("GET", url, true);
    req.send(null);
   }
  else
   { alert('Su navegador no cuenta con, al menos, uno de los m\xE9todos necesarios para el funcionamiento de este sistema.'); }
 }

function cargar_xml(url, hand, parametros)
 {
  if(window.XMLHttpRequest)
   {
   	var reqTiempo = new Date();
   	url += parametros ? '&': '?';
   	url += 'xml:reqTiempo='+reqTiempo.getTime();
    var req = new XMLHttpRequest();
    req.onreadystatechange = function()
	 {
	  if(req.readyState == 4)
	   {
		hand(req);
	   }
	 }
    req.open("GET", url, true);
    req.send(null);
   }
  else
   { alert('Su navegador no cuenta con, al menos, uno de los m\xE9todos necesarios para el funcionamiento de este sistema.'); }
 }

agregarEvento = function(elemento, evento, funcion)
 {
  if(typeof elemento == "string") elemento = document.getElementById(elemento);
  if(elemento == null) return false;
  if (elemento.addEventListener) elemento.addEventListener(evento, funcion, true);
  else elemento["on" + evento] = funcion;
 };


var SECCIONES = {};
var ATRIBUTOS = {};

function agregarIdioma(selector, cod, nombre)
 {
  totalopciones = selector.options.length;
  selector[totalopciones] = new Option(nombre, cod);
 }

function listadoIdiomas(req)
 {
    if(req.status == 200)
     {
	  var idiomas = req.responseXML.firstChild.firstChild.childNodes;
      if(idiomas.length >= 1)
	   {
	   	var selector = document.getElementById('idiomas').firstChild;
	   	selector[0] = null;
	   	var idioma_seleccionado;
		for (var i = 0; i < idiomas.length; i++)
		 {
		  leng_cod = idiomas[i].attributes.getNamedItem("xml:id").value;
		  leng_nombre = idiomas[i].firstChild.firstChild.nodeValue;
		  if(SELIDIOMA == leng_cod)
		   {
		   	idioma_seleccionado = i;
		   	agregarRegistro('Encontrado idioma preseleccionado, el idioma a usar es '+leng_nombre+'.', false, 0);
		   }
		  if(idiomas[i].attributes.getNamedItem("poromision")) poromision = i;
		  agregarIdioma(selector, leng_cod, leng_nombre);
		 }
	   }
	  leng_a_cargar = idioma_seleccionado ? idioma_seleccionado : poromision;
	  selector[leng_a_cargar].selected = true;
	  if(SELIDIOMA != false && idioma_seleccionado == null) agregarRegistro('No se encontró el idioma preseleccionado en los idiomas disponibles, se continúa utilizando el idioma '+selector[leng_a_cargar].text+' por ser predeterminado.', false, 0);
	  if(SELIDIOMA == false) agregarRegistro('El idioma predeterminado es '+selector[leng_a_cargar].text+'.', false, 0);
	  SELIDIOMA = selector[leng_a_cargar].value;
	  selector['onchange'] = function()
	   { actualizarIdioma(this.options[this.selectedIndex].value); }
     }
    else
	 {
	  agregarRegistro('No fue posible cargar lista de idiomas.\nHTTP status: '+req.status+'\nSe continúa sin idioma especificado.', false, 0);
	  SELIDIOMA = false;
	 }
	actualizarIdioma(SELIDIOMA);
  return;
 }

function limpiarFieldS(fieldsetId)
 {
  var elem = document.getElementById(fieldsetId);
  while(elem.childNodes[1])
   { elem.removeChild(elem.childNodes[1]); }
 }

function sinContenido(fieldsetId)
 {
  var elem = document.getElementById(fieldsetId);
  //elem.appendChild(document.createTextNode('No se aplica para esta sección.'));
  elem.style.display = 'none';
 }

function mostrarInfo(req)
 {
   	var elem = document.getElementById('info');
	elem.style.display = 'block';
    if(req.status == 200)
     {
	  elem.appendChild(document.createTextNode(req.responseText));
	  agregarRegistro('Se cargó la información de la sección.', false, 0);
     }
	else
	 {
	  var msj =	'No fue posible cargar los datos de la sección.';
	  divInfo.appendChild(document.createTextNode(msj));
	  agregarRegistro(msj+'\nHTTP status: '+req.status+' '+req.statusText, false, 1);
	 }
  return;
 }

function cargarInfo(seccion)
 {
  //cambiarEstado("Cargando información de sección /seccion/"+seccion+".xml."+SELIDIOMA, "info", true);
  var cod = '';
  if(SELIDIOMA != false)
	cod = '.'+SELIDIOMA;
  agregarRegistro('Consultando información de sección.', '/seccion/'+seccion+'.xml'+cod, 0);
  cargarXml('./seccion/'+seccion+'.xml'+cod, 'mostrarInfo', false);
 }

function Cats(id, nombre)
 {
  this.el = document.createElement('a');
  this.el.appendChild(document.createTextNode(nombre));
  this.el['onclick'] = function()
   {
   	cargarCategorias(id);
   	document.forms[0][0].value = id;
   	verValores();
   }
 }

function mostrarCategorias(req)
 {
 	divCats = document.getElementById('categorias');
 	divCats.style.display = 'block';
    if(req.status == 200)
     {
      var superior = req.responseXML.firstChild.firstChild.attributes.getNamedItem("superior").value;
	  var cont_cats = (superior == '0') ? document.getElementById('categorias') : document.getElementById('cat_'+superior);
	  while(cont_cats.childNodes[1])
	    cont_cats.removeChild(cont_cats.childNodes[1]);
      var lista = document.createElement('ul');
      cont_cats.appendChild(lista);
      var item = req.responseXML.getElementsByTagName('item');
      if(item != null)
       {
       	for(var i = 0; i < item.length; i++)
       	 {
		  var catId = item[i].attributes.getNamedItem("xml:id").value;
		  var li = document.createElement('li');
		  li.setAttribute('id', 'cat_'+catId);
		  var link = new Cats(catId, item[i].attributes.getNamedItem("categoria").value)
		  li.appendChild(link.el);
		  lista.appendChild(li);
       	 }
       }


	  //divCats.appendChild(document.createTextNode(req.responseText));
	  agregarRegistro('Se cargaron las categorías.', false, 0);
     }
	else
	 {
	  var msj =	'No fue posible cargar las categorías.';
	  divCats.appendChild(document.createTextNode(msj));
	  agregarRegistro(msj+'\nHTTP status: '+req.status+' '+req.statusText, false, 1);
	 }
	//cambiarEstado(false, "categorias", false);
  return;
 }

function cargarCategorias(cat)
 {
  var params = {};
  if(cat != 0) params['cat'] = cat;
  var leng = SELIDIOMA ? SELIDIOMA : '';
  var params_str = '';
  var i = 0;
  for(var x in params)
   {
	if(i != 0)
	 {
	  params_str += '&';
	  i++
	 }
	params_str += x+'='+params[x];
   }
  if(params_str != '')
   {
	params_str = '?'+params_str;
	t_params = true;
   }
  else
	t_params = false;
//   }
  agregarRegistro('Consultando categorías.', '/menuXml/categorias/'+SECCION+'/'+leng+params_str, 0);
  cargarXml('./menuXml/categorias/'+SECCION+'/'+leng+params_str, 'mostrarCategorias', t_params);
 }

function verValores()
 {
  form_filtrado = document.forms['filtrado'].elements;
var valores = '';
var parametros = {};
for(var i = 0; i < (form_filtrado.length -1) ; i++)
 {
  valores += i+': '+form_filtrado[i].name+' '+form_filtrado[i].value+'\n';
  if(form_filtrado[i].value == '') continue;
  parametros[form_filtrado[i].name] = form_filtrado[i].value;
 }
//alert(valores);
  cargarItems(parametros)
 }

function agregarFiltro(id, nombre)
 {
  var li = document.createElement('li');
  var etiqueta = document.createElement('label');
  etiqueta.appendChild(document.createTextNode(nombre+': '));
  var filtro = document.createElement('select');
  filtro.setAttribute('name', id);
  filtro.setAttribute('id', 'filtro_'+id);
  filtro[0] = new Option('--seleccione--', '');
  filtro['onchange'] = function()
   { verValores(); }
  li.appendChild(etiqueta);
  li.appendChild(filtro);
  document.getElementById('filtros').childNodes[1].appendChild(li);
  consultarFiltro(id, nombre, null);
  return;
 }

function cargarFiltro(req)
 {
  if(req.status == 200)
   {
	if(req.responseXML.firstChild.attributes) var selector = document.getElementById('filtro_'+req.responseXML.firstChild.attributes.getNamedItem("id").value)
	else return false;
	while(selector[0])
	  selector[0] = null;
	var opciones = req.responseXML.getElementsByTagName('opcion');
	var j = 0;
	for(var i = 0; i < opciones.length; i++)
	 {
	  if(opciones[i].firstChild != null)
	   {
	   	selector[j] = new Option(opciones[i].firstChild.nodeValue, opciones[i].attributes.getNamedItem("xml:id").value);
	   	j++
	   }
	 }
   }
 }

function consultarFiltro(id, nombre, atributos)
 {
  if(atributos == null) atributos = {};
  var cod = SELIDIOMA ? SELIDIOMA : '';
  var params_str = '';
  for(var x in atributos)
	params_str += '&'+x+'='+atributos[x];
  agregarRegistro('Consultando filtro '+nombre+'.', '/menuXml/filtro/'+SECCION+'/'+cod+'?id='+id+params_str, 0);
  cargarXml('./menuXml/filtro/'+SECCION+'/'+cod+'?id='+id+params_str, 'cargarFiltro', true);
 }

function crearTablaItems(req)
 {
  document.getElementById('items').style.display = 'block';
  if(req.status == 200)
   {
   	ATRIBUTOS = {};
   	orden = document.getElementById('orden');
   	while(orden[1])
	  orden[1] = null;
	var atributos = req.responseXML.getElementsByTagName('opcion');
	var tabla = document.getElementById('tabla_items');
   	while(tabla.firstChild)
	  tabla.removeChild(tabla.firstChild);
	var thead = document.createElement('thead');
	var tr = document.createElement('tr');
	var td = document.createElement('th');
	td.appendChild(document.createTextNode('Id'));
	tr.appendChild(td);

	var filtros = document.getElementById('filtros');
	while(filtros.childNodes[1])
	  filtros.removeChild(filtros.childNodes[1]);

	var ul = document.createElement('ul');

	filtros.appendChild(ul);
	cargarItems(null);
	for(var i = 0; i < atributos.length; i++)
	 {
	  var id = atributos[i].attributes.getNamedItem("id").value;
	  nombre = atributos[i].firstChild.nodeValue;
	  if(atributos[i].attributes.getNamedItem("filtro").value == 1)
	   {
	   	agregarFiltro(id, nombre);
		orden[orden.options.length] = new Option(nombre, id);
	   }
	  if(atributos[i].attributes.getNamedItem("salida").value == 0) continue;
	  ATRIBUTOS[id] = nombre;
	  var td = document.createElement('th');
	  td.appendChild(document.createTextNode(nombre));
	  tr.appendChild(td);
	 }
	thead.appendChild(tr);
	tabla.appendChild(thead);
   }
 }

function consAtributos(seccion)
 {
  cod = SELIDIOMA ? SELIDIOMA : '';
  agregarRegistro('Consultando atributos de items.', '/menuXml/atributos/'+seccion+'/'+cod, 0);
  cargarXml('./menuXml/atributos/'+seccion+'/'+cod, 'crearTablaItems', false);
  return;
 }

function linkItem(id)
 {
  this.el = document.createElement('a');
  this.id = id;
  this.el.appendChild(document.createTextNode(id));
  var self = this;
  this.el['onclick'] = function()
	{ alert('Acá va a cargar el item '+self.id+'.'); }
 }

function mostrarItems(req)
 {
  if(req.status == 200)
   {
	tabla = document.getElementById('tabla_items');
	var items = req.responseXML.getElementsByTagName('items');
	document.getElementById('rpp').value = items[0].attributes.getNamedItem("rpp").value;
	var resultados = document.getElementById('resultados').firstChild;
	resultados.replaceData(0, resultados.data.length, items[0].attributes.getNamedItem("total").value);
	var totPaginas = parseInt(items[0].attributes.getNamedItem("paginas").value);
	paginas = document.getElementById('pagina');
	var ultima = paginas.options.length;
	if(paginas.options.length > totPaginas)
	 {
	  while(ultima > totPaginas)
	   {
	   	ultima--
		paginas[ultima] = null;
	   }
	 }
	if(paginas.options.length < totPaginas)
	 {
	  while(paginas.options.length < totPaginas)
		paginas[ultima] = new Option(++ultima);
	 }
	var items = req.responseXML.getElementsByTagName('item');

	var tabla = document.getElementById('tabla_items');
	if(tabla.childNodes[1]) tabla.removeChild(tabla.childNodes[1]);
	var tbody = document.createElement('tbody');
	tabla.appendChild(tbody);

	for(var i = 0; i < items.length; i++)
	 {
	  var tr = document.createElement('tr');
	  var td = document.createElement('td');

	  //var a = document.createElement('a');
	  var a = new linkItem(items[i].attributes.getNamedItem("xml:id").value);
	  //var id = items[i].attributes.getNamedItem("xml:id").value;
	  //a.appendChild(document.createTextNode(id));
	  //a['onclick'] = function()
	  // { alert('Acá va a cargar el item '+id+'.'); }
	  td.appendChild(a.el);
	  tr.appendChild(td);
	  var item = items[i].childNodes;
	  var j = 0;
	  for(var x in ATRIBUTOS)
	   {
	    var td = document.createElement('td');
	    tr.appendChild(td);
	    if(item[j] == null) continue;
	    while(ATRIBUTOS[item[j].attributes.getNamedItem("id").value] == null)
		  j++
	    if(item[j].attributes.getNamedItem("id").value != x) continue;
	    switch(item[j].tagName)
		 {
		  case "dato":
			td.appendChild(document.createTextNode(item[j].firstChild.nodeValue));
		   break;
		  case "imagen":
			var imagen = new Image();
			imagen.src = '/'+item[j].attributes.getNamedItem("miniatura").value;
			td.appendChild(imagen);
		   break;
		  case "archivo":
			var arch = document.createElement('a');
			arch.setAttribute('href', '/'+item[j].attributes.getNamedItem("archivo").value);
			arch.appendChild(document.createTextNode('/'+item[j].attributes.getNamedItem("archivo").value));
			td.appendChild(arch);
		   break;
		 }
	    j++
	   }
	  tbody.appendChild(tr);
	  //ATRIBUTOS
	 }

	//<items etiqueta="Usados recomendados" total="3" rpp="25" pagina="1" paginas="1">
	agregarRegistro('Se cargaron los items', false, 0);

   }
  else
   {
	var msj = 'No fue posible cargar los items.';
	//divItems.appendChild(document.createTextNode(msj));
	agregarRegistro(msj+'\nHTTP status: '+req.status+' '+req.statusText, false, 1);
   }
  return;
 }

function cargarItems(parametros)
 {
  if(parametros == null) var parametros = {};
  leng = SELIDIOMA ? SELIDIOMA : '';
  var params_str = '';
//  if(t_params == true)
//   {
	var i = 0;
	for(var x in parametros)
	 {
	  if(i != 0)
	   {
	   	params_str += '&';
	   }
	  else
	    i++
	  params_str += x+'='+parametros[x];
	 }
	if(params_str != '')
	 {
	  params_str = '?'+params_str;
	  t_params = true;
	 }
	else
	  t_params = false;
//   }
  agregarRegistro('Consultando items.', '/menuXml/items/'+SECCION+'/'+leng+params_str, 0);
  cargarXml('./menuXml/items/'+SECCION+'/'+leng+params_str, 'mostrarItems', t_params);
 }

var TXTBOOL = new Array();
TXTBOOL[0] = 'No';
TXTBOOL[1] = 'Si';
/*
var CANALES = new Array();
CANALES[0] = 'info';
CANALES[1] = 'categorias';
CANALES[2] = 'items';
*/
function cargarSeccion(seccion)
 {
/*  if(SECCION == seccion)
   {
   	agregarRegistro(SECCIONES[SECCION].nombre+' ya es la sección seleccionada.', false, 0);
   	return;
   }
*/
  if(SECCION != false) document.getElementById('menu_'+SECCION).firstChild.style.fontWeight = "100";
  document.getElementById('menu_'+seccion).firstChild.style.fontWeight = "900";
  SECCION = seccion;
  agregarRegistro('Sección seleccionada: '+SECCIONES[SECCION].nombre+'.\n  Información: '+TXTBOOL[SECCIONES[SECCION].info]+'\n  Categorías: '+TXTBOOL[SECCIONES[SECCION].categorias]+'\n  Items: '+TXTBOOL[SECCIONES[SECCION].items], false, 0);
  document.getElementById('titulo').innerHTML = SECCIONES[SECCION].nombre;
//  for(i = 0; i < CANALES.length; i++)
//   {
   	//canal = CANALES[i];
	limpiarFieldS('info');
	info_popup = document.getElementById('info_popup');
	if(SECCIONES[seccion]['info'] == 1)
	  cargarInfo(seccion);
	else
	   sinContenido('info');
   	//canal = CANALES[i];
	limpiarFieldS('categorias');
	if(SECCIONES[seccion]['categorias'] == 1)
	  cargarCategorias(0);
	else
	   sinContenido('categorias');
   	//canal = CANALES[i];
	var elem = document.getElementById('items');
	while(elem.childNodes[3])
	 { elem.removeChild(elem.childNodes[3]); }
	if(SECCIONES[seccion]['items'] == 1)
	 {
	  consAtributos(seccion);
	 }
	else
	   sinContenido('items');
//   }
  //separadorRegistro();
 }

function cargarPopup(tipo)
 {
  if(SECCION == false || SECCIONES[SECCION]['info'] == 0) return false;
  cod = SELIDIOMA ? SELIDIOMA : '';
  var posicion = '';
  var ancho = 580;
  var alto = 700;
  posicion = "left="+((screen.width/2)-(ancho/2))+",";
  posicion += "top="+((screen.height/2)-(alto/2))+",";
  window.open('/xhtml/'+tipo+'/'+SECCION+'/'+cod, tipo, "modal=yes,width="+ancho+"px,height="+alto+"px,,"+posicion);
  agregarRegistro('Cargando '+tipo+' en una nueva ventana.', '/xhtml/'+tipo+'/'+SECCION+'/'+cod, 0);
 }
function el_seccion(nodo)
 {
  this.id = nodo.attributes.getNamedItem("xml:id").value;
  this.nombre = nodo.attributes.getNamedItem("nombre").value;
  this.tipo = nodo.attributes.getNamedItem("tipo").value;
  this.icono = nodo.attributes.getNamedItem("icono").value;
  this.info = nodo.attributes.getNamedItem("info").value;
  this.items = nodo.attributes.getNamedItem("items").value;
  this.categorias = nodo.attributes.getNamedItem("categorias").value;
  //this.rss = nodo.attributes.getNamedItem("rss").value;
  this.superior = nodo.parentNode.attributes.getNamedItem("xml:id") ? nodo.parentNode.attributes.getNamedItem("xml:id").value: false;
  this.elem = document.createElement('li');
  this.elem.setAttribute('id', 'menu_'+this.id);
  var link = document.createElement('a');
  var caronte = this;
  link.onclick = function()
	{ cargarSeccion(caronte.id); }
  link.appendChild(document.createTextNode(this.nombre));
  this.elem.appendChild(link);
  if(nodo.childNodes != null)
   {
	this.elem.appendChild(document.createElement('ul'));
   }
 }

function listadoSecciones(req)
 {
    if(req.status == 200)
     {
	  var secciones = req.responseXML.getElementsByTagName('seccion');
      if(secciones.length >= 1)
	   {
	   	var contenedor = document.getElementById('menu');
	   	while(contenedor.firstChild)
		 { contenedor.removeChild(contenedor.firstChild); }
		var lista = document.createElement('ul');
		contenedor.appendChild(lista);
		var sel_seccion = false;
		for(var i = 0; i < secciones.length; i++)
		 {
		  if(secciones[i].attributes.getNamedItem("xml:id") == null) continue;
		  id = secciones[i].attributes.getNamedItem("xml:id").value;
		  if(SECCION == id)
		   {
		   	sel_seccion = id;
			agregarRegistro('Se encontró la sección preseleccionada.', false, 0);
		   }
		  SECCIONES[id] = new el_seccion(secciones[i]);
		  if(SECCIONES[id].superior == false) lista.appendChild(SECCIONES[id].elem);
		  else
		   {
		   	sublista = document.getElementById('menu_'+SECCIONES[id].superior).childNodes[1];
		  	sublista.appendChild(SECCIONES[id].elem);
		   }
		 }
		SECCION = false;
		if(sel_seccion != false)
		  cargarSeccion(sel_seccion);
	   }
	  //agregarRegistro('No se pudo cargar el listado de secciones.\nError!\nHTTP status: '+req.status+'.\nHa finalizado la aplicación.', false, 0);
     }
    else
	 {
	  agregarRegistro('No se pudo cargar el listado de secciones.\nError!\nHTTP status: '+req.status+'.\nHa finalizado la aplicación.', false, 0);
	 }
  return;
 }

/*
function cambiarEstado(msj, id, mostrar)
 {
  div_estado = document.getElementById('estado');
  msj_estado = document.getElementById('estado_'+id);
  if(msj_estado == null)
   {
   	if(mostrar == true)
   	 {
	  var msj_estado = document.createElement('p');
	  msj_estado.setAttribute('id', 'estado_'+id);
	  div_estado.appendChild(msj_estado);
   	 }
   	else return;
   }
  else
   {
   	if(mostrar == true)
   	 {
	  msj_estado.removeChild(msj_estado.firstChild);
   	 }
   	else
   	 {
   	  div_estado.removeChild(msj_estado);
   	 }
   }
  msj_estado.appendChild(document.createTextNode(msj));
  div_estado.style.display = div_estado.childNodes ? 'block': 'none';
 }
*/

Date.prototype.hora = function()
 {
  var h = this.getHours();
  var m = this.getMinutes();
  var s = this.getSeconds();
  if(m < 10)
	m = "0" + m;
  if(s < 10)
	s = "0" + s;
  return h+':'+m+':'+s
 }

function agregarRegistro(msj, xml, nivel)
 {
  //registro = document.getElementById('registro');//Registro.document.body.firstChild;//
  var ingreso_h = document.createElement('dt');
  var tiempo = new Date();
  ingreso_h.appendChild(document.createTextNode(tiempo.hora()));
  //Registro.appendChild(ingreso_h);

  var ingreso = document.createElement('dd');
  ingreso.appendChild(document.createTextNode(msj+' '));
  if(xml)
   {
	var link = document.createElement('a');
	link.setAttribute('href', location.protocol+'//'+location.hostname+xml);
	link.setAttribute('target', '_blank');
	link.appendChild(document.createTextNode(xml));
	ingreso.appendChild(link);
   }
  //Registro.appendChild(ingreso);
  Registro.insertBefore(ingreso,Registro.firstChild);
  Registro.insertBefore(ingreso_h,Registro.firstChild);

/*
Registro.document.open("text/html","replace");
Registro.document.writeln(msj);
Registro.document.close();
*/

 }

function separadorRegistro()
 {
  document.getElementById('registro').appendChild(document.createElement('hr'));
 }

function actualizarIdioma(cod)
 {
  //var xmlIdioma = '';
  if(cod != false)
   {
	SELIDIOMA = cod;
	cod = '.'+cod;
   }
  else
	cod = '';
  agregarRegistro('Cargando información de secciones.', '/menuXml/secciones.xml'+cod, 0);
  //cambiarEstado("Cargando información de secciones", "secciones", true);
  cargarXml('./menuXml/secciones.xml'+cod, 'listadoSecciones', false);
 }

function cargarIdiomas()
 {
  //var registro = document.createElement('dl');
  //registro.setAttribute('id', 'registro');
  //document.getElementById('cont_reg').appendChild(registro);
  agregarRegistro('Iniciando rutina.\nParámetros pre-seleccionados vía GET:\n  Idioma (leng): '+SELIDIOMA+'\n  Sección (seccion): '+SECCION, false, 0);
  agregarRegistro('Cargando idiomas.', '/menuXml/idiomas', 0);
  cargarXml('./menuXml/idiomas', 'listadoIdiomas', false);

  sesion = getCookie('sesion');
  if(sesion != false)
	accederCuenta(false);
 }


var ventRegistro = window.open('', 'registro', 'width=200px,height=400px,directories=no,location=no,menubar=no,resizable=yes,scrollbars=yes,status=yes,titlebar=yes,toolbar=no');
var Registro = ventRegistro.document.createElement('pre');
ventRegistro.document.body.appendChild(Registro);

agregarEvento(window, 'load', cargarIdiomas);


function accederCuenta(formulario)
 {
  //if(formulario['usuario'].value != '' && formulario['clave'].value != '')
  // {
    if(window.XMLHttpRequest)
     {
   	  var reqTiempo = new Date();
      var req = new XMLHttpRequest();
      req.onreadystatechange = function()
	   {
	    if(req.readyState == 4)
	     {
		  resLogin(req);
	     }
	   }
      if(formulario == false)
	   {
		req.open("GET", '/menuXml/login?xml:reqTiempo='+reqTiempo.getTime(), true);
		req.send(null);
	   }
	  else
	   {
		req.open("POST", '/menuXml/login?accion=login&xml:reqTiempo='+reqTiempo.getTime(), true);
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.send('&usuario='+formulario['usuario'].value+'&clave='+formulario['clave'].value);
	   }
     }
    else
     { alert('Su navegador no cuenta con, al menos, uno de los m\xE9todos necesarios para el funcionamiento de este sistema.'); }
  return false;
  // }
 }

function getCookie(c_name)
 {
  if(document.cookie.length>0)
   {
	c_start=document.cookie.indexOf(c_name + "=");
	if(c_start!=-1)
     {
      c_start=c_start + c_name.length+1;
      c_end=document.cookie.indexOf(";",c_start);
      if (c_end==-1) c_end=document.cookie.length;
      return unescape(document.cookie.substring(c_start,c_end));
     }
   }
  return false;
 }

var respuestasLogin = ["",
	"Debe completar ambos campos para ingresar.",
	"Los datos proporcionados no son correctos.",
	"Acceso aceptado.",
	"Su sesión ha sido cerrada satisfactoriamente.",
	"Sesión activa.",
	"Su sesión ha expirado o no ha iniciado una.",
	"Usted no tiene permisos para acceder a este documento.",
	"No fue posible conectar con la base de datos."];
var sesionEstado = false;
var sesion;
function resLogin(req)
 {
  var xml = req.responseXML;
  var suceso = xml.documentElement.getElementsByTagName("suceso")[0];
  var sucesoId = suceso.getAttribute("id");
  var avisoSuceso = document.getElementById('login_sucesos');
  while(avisoSuceso.firstChild != null)
    avisoSuceso.removeChild(avisoSuceso.firstChild);
  var loginUsuario = document.getElementById('login_usuario');
alert(req.responseText)
  if(sucesoId == 3 || sucesoId == 5)
   {

   	//var scookie = document.cookie.split('=')
   	//eval('var '+scookie[0]+' = \''+scookie[1]+'\';');
   	//var sesion = getCookie('sesion');
   	//alert(sesion);

	while(loginUsuario.childNodes[2] != null)
	   loginUsuario.removeChild(loginUsuario.childNodes[2]);
	var nombreUsEl = xml.documentElement.getElementsByTagName("usuario")[0];
	//var nombreUs = document.createElement('b');
	//nombreUs.appendChild(document.createTextNode(nombreUsEl.firstChild.nodeValue+' '))
	//avisoSuceso.appendChild(nombreUs);
	loginUsuario.firstChild.firstChild.replaceData(0, loginUsuario.firstChild.firstChild.length, nombreUsEl.firstChild.nodeValue);
	var a = document.createElement('a');
	a.onclick = function ()
	 { cargarXml('/menuXml/login?accion=cerrar', 'resLogin', true); };
	a.appendChild(document.createTextNode('Cerrar sesión'));

	avisoSuceso.appendChild(a);
   }
  else if(sucesoId == 4)
   {
   	var ul = document.createElement('ul');


   	var li = document.createElement('li');

   	var label = document.createElement('label');
   	label.setAttribute('for', 'acc_usuario');
	label.appendChild(document.createTextNode('Usuario'));
	li.appendChild(label);
	var input = document.createElement('input');
	input.setAttribute('type', 'text');
	input.setAttribute('name', 'usuario');
	input.setAttribute('id', 'acc_usuario');
   	li.appendChild(input);
   	ul.appendChild(li);

   	var li = document.createElement('li');
   	ul.appendChild(li);
   	var label = document.createElement('label');
   	label.setAttribute('for', 'acc_clave');
	label.appendChild(document.createTextNode('Contraseña'));
	li.appendChild(label);
	var input = document.createElement('input');
	input.setAttribute('type', 'password');
	input.setAttribute('name', 'clave');
	input.setAttribute('id', 'acc_clave');
   	li.appendChild(input);


	var li = document.createElement('li');
   	ul.appendChild(li);
	var input = document.createElement('input');
	input.setAttribute('type', 'button');
	input.setAttribute('value', 'Entrar');
	input.onclick = function()
	 { accederCuenta(this.form);	};
   	li.appendChild(input);
   	loginUsuario.appendChild(ul);
   }
  else
   {
   	avisoSuceso.appendChild(document.createTextNode(suceso.firstChild.nodeValue));
   }
 }

function habEnvioAcc(formulario)
 {
  formulario['acc_enviar'].checked = (formulario['usuario'].value.length >= 1 && formulario['clave'].value.length >= 1);
 }
