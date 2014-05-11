
function peticionXML(url, hand, params)
 {
  var pet;
  if(window.XMLHttpRequest && !(window.ActiveXObject))
   {
    pet = new XMLHttpRequest();
   }
  else if(window.ActiveXObject)
   {
    try
	 {
      pet = new ActiveXObject("Msxml2.XMLHTTP");
     }
	catch(e)
	 {
      try
	   {
        pet = new ActiveXObject("Microsoft.XMLHTTP");
       }
	  catch(e)
	   {
        pet = false;
       }
	 }
   }
  pet.onreadystatechange = function() // hand();
   {
	if(pet.readyState == 4)
	 {
	  hand(pet, params);// eval(hand+"(pet, elAviso)");
	 }
   };
  pet.open("GET", url, true);
  pet.send("");
//  else
//   { alert('Su navegador no cuenta con, al menos, uno de los m\xE9todos necesarios para el funcionamiento del formulario.'); }
 }

function cargarSeccionesN(req, params)
 {
  if(req.status == 200)
   {
	var secciones = req.responseXML.getElementsByTagName("seccion");
	Secciones[params.lenguaje] = {};
	for(var i = 0; i < secciones.length; i++)
	 {
	  attributos = secciones[i].attributes;
	  Secciones[params.lenguaje][attributos.getNamedItem("xml:id").nodeValue] = attributos.getNamedItem("nombre").nodeValue;
	 }
//for(var xx in secciones[0].attributes[0])
//  alert(xx+': ('+typeof secciones[0].attributes[0][xx]+') '+secciones[0].attributes[0][xx]);
	params.instancia.selSeccion(params.instancia.seccion);
   }
 }

var instanciaFlash = function(peliculaNombre)
 {
  this.pelicula = null;
  this.peliculaNombre = peliculaNombre;
  this.preparada = false;
  this.leng = 'es';
  this.seccion = 'home';
  this.categoria = 0;
  this.item = 0;
 }

/*
instanciaFlash.prototype = {
  recFlashEmbed : function()
   {
	if(window.document[this.peliculaNombre])
	  return window.document[this.peliculaNombre];
	if(document.embeds && document.embeds.namedItem(this.peliculaNombre))
	  return document.embeds.namedItem(this.peliculaNombre);
	return document.getElementById(this.peliculaNombre);
   },
  peliculaLista : function() {
  	this.preparada = true;
  	this.pelicula = this.recFlashEmbed();
   },
  selIdioma : function(leng) {
  	this.leng = leng;
  	return true;
   },
  recIdioma : function() {
  	return this.leng;
   },
  selSeccion : function(seccion) {
  	this.seccion = seccion;
  	return true;
   },
  recSeccion : function() {
  	return this.seccion;
   },
  selCategoria : function() {
  	return true;
   },
  recCategoria : function() {
  	return this.categoria;
   },
  selItem : function() {
  	return true;
   },
  recItem : function() {
  	return this.item;
   },
 };
*/

instanciaFlash.prototype.recFlashEmbed = function()
 {
  if(window.document[this.peliculaNombre])
	return window.document[this.peliculaNombre];
  if(document.embeds && document.embeds.namedItem(this.peliculaNombre))
	return document.embeds.namedItem(this.peliculaNombre);
  return document.getElementById(this.peliculaNombre);
 }
instanciaFlash.prototype.peliculaLista = function()
 {
  this.preparada = true;
  this.pelicula = this.recFlashEmbed();
 }
instanciaFlash.prototype.selIdioma = function(leng)
 {
  this.leng = leng;
  if(Secciones[this.leng] == null)
	peticionXML('/menuXml/secciones.xml.'+this.leng, cargarSeccionesN, {lenguaje : this.leng, instancia : this});
  else
	this.selSeccion(this.seccion);
  return true;
 }
instanciaFlash.prototype.recIdioma = function()
 {
  return this.leng;
 }
instanciaFlash.prototype.selSeccion = function(seccion)
 {
//alert(seccion);
  if(seccion == this.seccion)
	return false;
  if(Secciones[this.leng])
	document.title = Secciones[this.leng][seccion]+' - '+Titulo;
  colaIframe(seccion);
  this.seccion = seccion;
  return true;
 }
instanciaFlash.prototype.recSeccion = function()
 {
  return this.seccion;
 }
instanciaFlash.prototype.selCategoria = function()
 {
  return true;
 }
instanciaFlash.prototype.recCategoria = function()
 {
  return this.categoria;
 }
instanciaFlash.prototype.selItem = function()
 {
  return true;
 }
instanciaFlash.prototype.recItem = function()
 {
  return this.item;
 }
