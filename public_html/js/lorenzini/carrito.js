
var subCategorias = {}
var Cat0 = 0;
var Cat1 = null;
var Pagina = 1;
var Codigo;
var Cargando = false;

function errorSesion()
 {

 }

function mostrarCarga()
 {
  
 }

function obtenerItems()
 {
  var envio = XHR();
  if(envio == null)
	return true;
  Cargando = true;
  //borradoItems()
  mostrarCarga();
  envio.onreadystatechange = function() // hand();
   {
	if(envio.readyState == 4)
     {
      if(envio.status == 401)
        mostrarLogin();
      else
        cargaItems(envio);//, params);//eval(hand+"(pet, elAviso)");
     }
   };
  var params = new Array();
  if(Codigo)
   {
    params.push('codigo='+encodeURIComponent(Codigo));
   }
  else
   {
    if(Cat0)
	  params.push('cat%5B0%5D='+Cat0);
    if(Cat1)
	  params.push('cat%5B1%5D='+Cat1);
   }
  params.push('pagina='+Pagina);
  params.push('leng='+lengCod);

//var pre = document.getElementById('pre');
//pre.innerHTML = '<a href="/json/lorenzini/productos?'+params.join("&")+'">/json/lorenzini/productos?'+params.join("&")+'</a>';
//window.status = '/json/lorenzini/productos?'+params.join("&");
  envio.open("GET", '/json/lorenzini/productos?'+params.join("&"), true);
  envio.send(null);
//  envio.open("POST", url, true);
//  envio.setRequestHeader('Content-Type', contenidoTipo);//'application/x-www-form-urlencoded');
//  envio.send(datos);
  return false;
 }

function borradoItems()
 {
  var catalogoCont = document.getElementById('catalogo');
  while(catalogoCont.firstChild != null)
   {
    catalogoCont.removeChild(catalogoCont.firstChild);
   }
 }

function cargaItems(envio)
 {
  var catalogoCont = document.getElementById('catalogo');
  try
   {
	var respuesta = eval('('+envio.responseText+')');
   }
  catch(e)
   {
    alert("error\n"+envio.statusText+" "+envio.status+"\n"+envio.responseText)
    return;
	//respuesta = {exito : false};
   }

  productos = respuesta.productos;
  paginador.total = respuesta.total;
  paginador.pagina = respuesta.pagina;
  paginador.paginas = respuesta.paginas;
  paginador.mostrar();

  while(catalogoCont.firstChild != null)
   {
    catalogoCont.removeChild(catalogoCont.firstChild);
   }
  var producto, div, em, img, input, button, cat, span;
  //for(var i = 0; i < respuesta.productos.length; i++)
  for(var i in respuesta.productos)
   {
    producto = respuesta.productos[i];
    if(producto.codigo == null || producto.precio == 0)
     {
      continue;
     }
	div = document.createElement('div');
	em = document.createElement('em');
	em.appendChild(document.createTextNode(producto.titulo));
	em.appendChild(document.createTextNode('\u00a0'));
    em.title = Textos[lengCod]['titulo'];
    agregarEventoMostrarDetalle(em, i);
	div.appendChild(em);
	em = document.createElement('code');
    em.title = Textos[lengCod]['codigo'];
	em.appendChild(document.createTextNode(producto.codigo));
	div.appendChild(em);
    cat = producto.categoria_id;
    if(cat != '0')
     {
      em = document.createElement('span');
      em.className = 'categoria';
      em.title = Textos[lengCod]['categoria'];
      do
       {
        if(cat != producto.categoria_id)
         {
          em.insertBefore(document.createTextNode(Categorias[cat].titulo+'/'), em.firstChild);
         }
        else
         {
          em.appendChild(document.createTextNode(Categorias[cat].titulo));
         }
        cat = Categorias[cat].superior;
       }while(cat != '0')
      div.appendChild(em);
     }
	img = new Image();
	img.src = '/img/1/'+producto.img[0];
    agregarEventoMostrarDetalle(img, i);
	div.appendChild(img);

	em = document.createElement('span');
    em.className = 'precio_publico';
    span = document.createElement('label');
    span.appendChild(document.createTextNode(Textos[lengCod]['preciopublico']+' '));
    em.appendChild(span);
	em.appendChild(document.createTextNode(producto.preciopublico));
	div.appendChild(em);

    em = document.createElement('span');
    em.className = 'ag_carro';
	em.appendChild(document.createTextNode(carrito.formatoPrecio(producto.precio)+' '));

	input = document.createElement('input');
	input.setAttribute('type', 'text');
	input.setAttribute('size', '3');
	input.setAttribute('maxlength', '4');
	input.setAttribute('name', 'cantidad['+producto.id+']');
	input.value = '1';
    agregarEvento(input, 'keypress', validarNum);
	em.appendChild(input);

	input = document.createElement('input');
	input.setAttribute('type', 'hidden');
	input.setAttribute('name', 'id['+producto.id+']');
	input.setAttribute('value', producto.id);
	em.appendChild(input);
	em.appendChild(document.createTextNode('\u00a0'));

	button = document.createElement('button');
	button.setAttribute('type', 'button');
    button.title = Textos[lengCod]['agregar'];
	agregarEvento(button, 'click', agregarCarroBind);
	span = document.createElement('span');
	span.appendChild(document.createTextNode(Textos[lengCod]['agregar']));
	button.appendChild(span);
	em.appendChild(button);
	div.appendChild(em);

	catalogoCont.appendChild(div);
/*	<div>
 -- '.$v->id.' '.$v->num__preciocoste.' --
 <em>'.$v->string__titulo.'</em>
 <code class="codigo">'.$v->string__codigo.'</code>
 <img src="/img/1/'.$img[0].'" alt="" width="'.$img[5].'" height="'.$img[6].'" />
 <span class="precio_publico">'.$v->string__preciopublico.'</span>
 <span class="precio">'.$v->string__preciocoste.'</span>
 <input type="text" name="cantidad['.$v->id.']" value="1" size="2" /> <button type="button" onclick="agregarCarro('.$v->id.', this.previousSibling.previousSibling.value)">Agregar al carro</button>
</div>
*/

   }
  Cargando = false;
//  {"total":"6","paginas":1,"rpp":25,"productos":}
 }

function validarNum(event)
 {
  if(event.charCode == 0)
	return;// true;
  var keynum;
  if(window.event)
   {
	keynum = event.keyCode;
   }
  else if(event.which)
   {
	keynum = event.which;
   }
  var keychar = String.fromCharCode(keynum);
  numcheck = /\d/
  if(numcheck.test(keychar) == false)
   {
    event.preventDefault();
   }
  //return numcheck.test(keychar);
 }

function cargaCategorias()
 {
  var selCat = document.getElementById('cat_0');
  //var selCat1 = document.getElementById('cat_1');
  for(var k in Categorias)
   {
	if(Categorias[k].superior == 0)
	 {
	  try{
		selCat.add(new Option(Categorias[k].titulo, Categorias[k].id), null)
	   }
	  catch(e){
		selCat.add(new Option(Categorias[k].titulo, Categorias[k].id))
	   }
	 }
	else
	 {
	  if(subCategorias[Categorias[k].superior] == null)
		subCategorias[Categorias[k].superior] = new Array();
	  subCategorias[Categorias[k].superior].push(k);
	 }
   }
 }

function cargaSubcategorias(superior)
 {
  Pagina = 1;
  Cat0 = parseInt(superior);
  Cat1 = null;
  obtenerItems();
  var selCat = document.getElementById('cat_1');
  while(selCat.options.length > 1)
	selCat.remove(1);
  if(subCategorias[superior])
   {
	for(var i = 0; i < subCategorias[superior].length; i++)
	 {
	  try{
		selCat.add(new Option(Categorias[subCategorias[superior][i]].titulo, Categorias[subCategorias[superior][i]].id), null)
	   }
	  catch(e){
		selCat.add(new Option(Categorias[subCategorias[superior][i]].titulo, Categorias[subCategorias[superior][i]].id))
	   }
	 }
   }
  //else
  //	alert('no existe');
 }

function cargaSubcategoria(catId)
 {
  Cat1 = (catId == '0') ? null : catId;
  obtenerItems();
 }

function readCookie(name)
 {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++)
   {
	var c = ca[i];
	while(c.charAt(0)==' ')
      c = c.substring(1,c.length);
	if(c.indexOf(nameEQ) == 0)
      return c.substring(nameEQ.length,c.length);
   }
  return null;
 }

function cargaCodigo(valor)
 {
  Codigo = valor;
  Pagina = 1;
  obtenerItems();
 }


var paginador = new Paginado();
paginador.listener = function(pagina) {
  Pagina = pagina;
  obtenerItems();
 }


//function Producto(id)
// {
//  this.id = id;
//  this.titulo = productos[id].titulo;
//  this.img = productos[id].img[0];
//  this.precio = productos[id].precio;
// }

function Carrito()
 {
  this.htmlElTotal = document.getElementById('carro_total');
  this.htmlEl = document.createElement('table');
  this.htmlElContenido = document.getElementById('carro_contenido');
  this.htmlElContenido.insertBefore(this.htmlEl, this.htmlElContenido.childNodes[0])
  this.productos = {};
  this.subtotal = 0;
  this.inicializado = false;
  this.visible = true;
 }

Carrito.prototype.visibildad = function(el)
 {
  var cont = el.parentNode.parentNode;
  if(this.visible == true)
   {
    //this.htmlElContenido.style.display = 'none';
    this.visible = false;
    el.style.backgroundImage="url(/img/c_n)";
    cont.style.height = el.parentNode.offsetHeight+'px';
    cont.style.overflow = 'hidden';
   }
  else
   {
    //this.htmlElContenido.style.display = 'block';
    this.visible = true;
    el.style.backgroundImage="url(/img/e_n)";
    cont.style.height = '100%';
    cont.style.overflow = 'auto';
   }
 }

Carrito.prototype.total = function()
 {
  this.subtotal = 0;
  var items = 0;
  for(var j in this.productos)
   {
	this.subtotal += (this.productos[j].precio * this.productos[j].cantidad);
    items += this.productos[j].cantidad;
   }
  document.getElementById('carro_enviar').disabled = (items == 0);
  //document.getElementById('carro_total_items').firstChild.data = '('+items+'\u00a0artículo'+(items > 1 ? 's' : '')+')';
  document.getElementById('carro_total_items').innerHTML = '('+items+'\u00a0artículo'+(items > 1 ? 's' : '')+')';
  //this.htmlElTotal.firstChild.data = this.formatoPrecio(this.subtotal);
  this.htmlElTotal.innerHTML = this.formatoPrecio(this.subtotal);
 }

//Carrito.prototype.agregar = function(idProducto, cantidad)
Carrito.prototype.agregar = function(idProducto, cantidad)
 {
  if(this.inicializado == false)
   {
    document.getElementById('carro').style.display = 'block';
    this.inicializado = true;
   }
  cantidad = parseInt(cantidad)
  if(cantidad > 9999)
   {
    cantidad = 9999;
   }
  if(this.productos[idProducto])
   {
    this.productos[idProducto].cantidad = cantidad;
    this.productos[idProducto].htmlEl.cells[0].childNodes[1].value = cantidad;
    this.productos[idProducto].htmlEl.cells[3].firstChild.firstChild.data = this.formatoPrecio(this.productos[idProducto].precio * cantidad);
   }
  else
   {
    if(productos[idProducto])
     {
      this.productos[idProducto] = {}
      this.productos[idProducto].cantidad = cantidad;
      this.productos[idProducto].precio = productos[idProducto].precio;
      this.productos[idProducto].htmlEl = this.htmlEl.insertRow(0);
      var cell = this.productos[idProducto].htmlEl.insertCell(0);
      cell.className = 'cantidad';
      var input = document.createElement('input');
      input.setAttribute('type', 'hidden');
      input.value = idProducto;
      cell.appendChild(input);
      input = document.createElement('input');
      input.setAttribute('type', 'text');
      input.setAttribute('size', '3');
      input.setAttribute('maxlength', '4');
      input.value = cantidad;
      agregarEvento(input, 'keypress', validarNum);
      agregarEvento(input, 'keyup', agregarCarroBind);
      agregarEvento(input, 'blur', agregarCarroBind);
      cell.appendChild(input);
      cell = this.productos[idProducto].htmlEl.insertCell(1);
      cell.className = 'descripcion';
      var b = document.createElement('em');
      b.appendChild(document.createTextNode(productos[idProducto].titulo));
      b.title = Textos[lengCod]['titulo'];
      cell.appendChild(b);
      b = document.createElement('code');
      b.appendChild(document.createTextNode(productos[idProducto].codigo));
      cell.appendChild(b);
      cell = this.productos[idProducto].htmlEl.insertCell(2);
      cell.className = 'imagen';
      var img = new Image();
      img.src = '/img/1/'+productos[idProducto].img[0];
      img.width = '40';
      img.height = '40';
      cell.appendChild(img);
      cell = this.productos[idProducto].htmlEl.insertCell(3);
      cell.className = 'subtotal';
      b = document.createElement('span');
      b.className = 'precio';
      b.appendChild(document.createTextNode(this.formatoPrecio(productos[idProducto].precio * cantidad)));
      cell.appendChild(b);
      b = document.createElement('a');
      b.appendChild(document.createTextNode(Textos[lengCod]['remover']));
      agregarEvento(b, 'click', quitarCarroBind);
      cell.appendChild(b);

      //this.productos[idProducto].htmlEl.appendChild(document.createTextNode(productos[idProducto].titulo));
      //this.htmlEl.insertBefore(this.productos[idProducto].htmlEl, this.htmlEl.childNodes[1]);
     }
   }
 }

Carrito.prototype.quitar = function(idProducto)
 {
  if(this.productos[idProducto] != null)
   {
    this.htmlEl.deleteRow(this.productos[idProducto].htmlEl.rowIndex);
    delete this.productos[idProducto];
    //this.productos.splice(idProducto, 1);
   }
  this.total();
 }

Carrito.prototype.vaciar = function()
 {
  for(var x in this.productos)
   {
    this.quitar(x);
   }
  this.visibildad(document.getElementById('carro_titulo').firstChild);
 }

Carrito.prototype.formatoPrecio = function(num)
 {
  num = ''+num.toFixed(2);
  num = num.replace(".", ",");
  var sRegExp = new RegExp('(-?[0-9]+)([0-9]{3})');
  while(sRegExp.test(num))
   {
    num = num.replace(sRegExp, '$1.$2');
   }
  return '\u20ac '+num;
 }

Carrito.prototype.enviar = function()
 {
  var datos = new Array();
  var envio = new XHR();
  var self = this;
  envio.onreadystatechange = function() // hand();
   {
	if(envio.readyState == 4)
     {
	  alert('Pedido realizado');//envio.responseText);//, params eval(hand+"(pet, elAviso)");
      self.vaciar();
     }
   };
  for(var x in this.productos)
   {
    datos.push('i%5B'+x+'%5D='+this.productos[x].cantidad);
   }
  envio.open("POST", '/json/lorenzini/pedido', true);
  envio.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  envio.setRequestHeader('Accept', 'application/json, application/*; q=0.1');
  envio.send(datos.join("&"));
  return false;
  // ({89:{cantidad:3, precio:44.5, htmlEl:{}}, 94:{cantidad:1, precio:47, htmlEl:{}}, 311:{cantidad:5, precio:88, htmlEl:{}}, 120:{cantidad:13, precio:46, htmlEl:{}}})
 }

var productos;
var carrito;

function agregarCarroBind(event)
 {
  var bot = event.target || event.srcElement;
  var cantidad;
  if(event.type == 'click')
   {
    cantidad = parseInt(bot.previousSibling.previousSibling.previousSibling.value);
    if(isFinite(cantidad) && cantidad >= 1)
     {
      var idProducto = parseInt(bot.previousSibling.previousSibling.value);
      if(carrito.productos[idProducto])
       {
        cantidad += carrito.productos[idProducto].cantidad;
       }
      carrito.agregar(idProducto, cantidad);
     }
   }
  else if(event.type == 'keyup')
   {
    cantidad = parseInt(bot.value);
    if(isFinite(cantidad) && cantidad >= 1)
     {
      carrito.agregar(bot.previousSibling.value, bot.value);
     }
   }
  else if(event.type == 'blur')
   {
    //var cantidad = parseInt(bot.value);
    if(bot.value == '')
     {
      bot.value = carrito.productos[bot.previousSibling.value].cantidad;
     }
    else if(parseInt(bot.value) == 0)
     {
      carrito.quitar(bot.previousSibling.value);
     }
   }
  carrito.total();
 }

function quitarCarroBind(event)
 {
  var bot = event.target || event.srcElement;
  carrito.quitar(bot.parentNode.parentNode.cells[0].firstChild.value);
 }


function iniciarCarro()
 {
  cargarIdioma();
  carrito = new Carrito();
  paginador.agregarContenedorHTML('paginado');
  estiloSelectores();
  if(readCookie('usuario') != null)
   {
    cargaCategorias();
    obtenerItems();
   }
  else
   {
    mostrarLogin();
   }
 }

function cargarIdioma()
 {
  document.getElementById('explorar_cats').innerHTML = Textos[lengCod]['explorar_cats'];
  document.getElementById('buscar_codigo').innerHTML = Textos[lengCod]['buscar_codigo'];
  document.getElementById('label_codigo').innerHTML = Textos[lengCod]['codigo'];
  document.getElementById('carro_titulo').firstChild.innerHTML = Textos[lengCod]['carrito'];
  document.getElementById('total').firstChild.innerHTML = Textos[lengCod]['total'];
  document.getElementById('carro_enviar').firstChild.innerHTML = Textos[lengCod]['enviar_pedido'];
/*
  document.getElementById('explorar_cats').firstChild.data = Textos[lengCod]['explorar_cats'];
  document.getElementById('buscar_codigo').firstChild.data = Textos[lengCod]['buscar_codigo'];
  document.getElementById('carro_titulo').firstChild.firstChild.data = Textos[lengCod]['carrito'];
  document.getElementById('total').firstChild.firstChild.data = Textos[lengCod]['total'];
  document.getElementById('carro_enviar').firstChild.firstChild.data = Textos[lengCod]['enviar_pedido'];
*/
 }

function mostrarLogin()
 {
  var fieldset = document.createElement('fieldset');
  var label = document.createElement('legend');
  label.appendChild(document.createTextNode('Acceso de usuarios'));
  fieldset.appendChild(label);
  var aviso = document.createElement('p');
  aviso.id = 'aviso';
  fieldset.appendChild(aviso);
  var form = document.createElement('form');
  form.method = "post";
  //name="login" action="/login" method="post" onsubmit="return loginAcceso(this);">
  fieldset.appendChild(form);
  agregarEvento(form, 'submit', loginAcceso);
  var ul = document.createElement('ul');
  form.appendChild(ul);
  //<ul id="camposlogin">
  var li = document.createElement('li');
  label = document.createElement('label');
  label.appendChild(document.createTextNode('Usuario'));
  label.setAttribute('for', 'usuario');
  label.className = 'izq';
  li.appendChild(label);
  li.appendChild(document.createTextNode(' '));
  var input = document.createElement('input');
  input.type = "text";
  input.name = "usuario";
  input.id = "usuario";
  li.appendChild(input);
  ul.appendChild(li);

  li = document.createElement('li');
  label = document.createElement('label');
  label.appendChild(document.createTextNode('Contraseña'));
  label.setAttribute('for', 'clave');
  label.className = 'izq';
  li.appendChild(label);
  li.appendChild(document.createTextNode(' '));
  input = document.createElement('input');
  input.type = "password";
  input.name = "clave";
  input.id = "clave";
  li.appendChild(input);
  ul.appendChild(li);
  // <li><span class="izq"><input type="checkbox" name="recordarme" id="recordarme" value="1" /></span> <label for="recordarme">Recordarme entre sesiones</label></li>

  li = document.createElement('li');
  var span = document.createElement('span');
  span.id = "envio";
  input = document.createElement('input');
  input.type = "submit";
  input.value = "Ingresar";
  input.className = "boton";
  span.appendChild(input);
  li.appendChild(span);
      
  ul.appendChild(li);
  // p id="recuperarclave"><a href="./recuperarclave">&iquest;Olvid&oacute; su contrase&ntilde;a?</a></p>
  document.getElementById('catalogo').appendChild(fieldset);
 }

function loginAcceso(event)
 {
  var formulario = event.target;
  var loginaviso = document.getElementById('aviso');
  while(loginaviso.firstChild)
	loginaviso.removeChild(loginaviso.firstChild);
  //deshabilitarFormLogin(true);
  var usuario = trim(formulario.elements[0].value);
  var clave = trim(formulario.elements[1].value);
  if(usuario == '' || clave == '')
   {
	loginaviso.appendChild(document.createTextNode('LOGIN_TEXTOS'));//LOGIN_TEXTOS['mensajes'][7]
	deshabilitarFormLogin(false);
	if(usuario == '')
	  agregarErrorCampo('usuario', 1);
	if(clave == '')
	  agregarErrorCampo('clave', 1);
	return false;
   }

  //var params = {};
  var datos = new Array();
  datos.push('usuario='+encodeURIComponent(usuario));
  datos.push('clave='+encodeURIComponent(clave));
  if(formulario.elements[4].type == 'checkbox' && formulario.elements[4].checked == true)
	datos.push('recordarme=1');

  loginaviso.className = 'cargando';
  loginaviso.appendChild(document.createTextNode(LOGIN_TEXTOS[0]));
  //enviarXHR('/api/login', loginRespuesta, datos, false, params);
  var envio = new XHR();
  envio.onreadystatechange = function() // hand();
   {
	if(envio.readyState == 4)
	  loginRespuesta(envio);//, params eval(hand+"(pet, elAviso)");
   };
  envio.open("POST", '/api/v1/login', true);
  envio.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  envio.setRequestHeader('Accept', 'application/json, application/*; q=0.1');
  envio.send(datos.join("&"));
  return false;
 }

function agregarEventoMostrarDetalle(el, id)
 {
  agregarEvento(el, 'click', function() {
    obtenerDetalle(id);
   });
 }

function ocultarDetalle()
 {
  document.body.removeChild(document.getElementById('mascara'));
  document.body.removeChild(document.getElementById('ampliacionCont'));
 }

function mostrarDetalle(respuesta, cont)
 {
  var datos = respuesta.getElementsByTagName("dato");//[0].childNodes;//firstChild.firstChild.childNodes;
  for(var i = 0; i < datos.length; i++)
   {
    if(datos[i].getAttribute("id") == 'descripcion')
     {
      cont.appendChild(document.createTextNode(datos[i].firstChild.nodeValue));
      break;
     }
   }
 }

function obtenerDetalle(id)
 {
  var mascara = document.createElement('div');
  mascara.id = 'mascara';
  mascara.style.height = document.body.offsetHeight+'px';
  document.body.appendChild(mascara);

  var ampliacionCont = document.createElement('div');
  ampliacionCont.id = 'ampliacionCont';
  var ampliacion = document.createElement('div');
  ampliacion.id = 'ampliacion';
  var div = document.createElement('div');
  ampliacion.appendChild(div);
  var X = new Image();
  X.src = '/img/cerrar'
  X.className = 'cerrar';
  agregarEvento(X, 'click', ocultarDetalle);
  div.appendChild(X);

  var imagen = new Image();
  imagen.src = '/img/0/'+productos[id].img[0];//      datos[i].getAttribute("archivo");
  imagen.width = productos[id].img[3];//      datos[i].getAttribute("ancho");
  imagen.height = productos[id].img[4];//      datos[i].getAttribute("alto");
  div.appendChild(imagen);

  var p = document.createElement('p');
  p.id = 'ampliacion_desc'
  div.appendChild(p);
  div.appendChild(document.createElement('hr'));
//divSubir.style.top = (window.innerHeight/2 - 50)+'px';
//divSubir.style.left = (window.innerWidth/2 - 180)+'px';
//alert(window.scrollWidth+' - '+window.scrollHeight)
//alert(window.innerWidth+' - '+window.innerHeight)
 // div.style

  var envio = XHR();
  envio.onreadystatechange = function() // hand();
   {
	if(envio.readyState == 4)
     {
      mostrarDetalle(envio.responseXML, p);
     }
   };
  envio.open("GET", '/item/'+id+'.xml.'+lengCod);
  envio.send(null);

  var ScrollTop = document.body.scrollTop;
  if (ScrollTop == 0)
   {
    if(window.pageYOffset)
      ScrollTop = window.pageYOffset;
    else
      ScrollTop = (document.body.parentElement) ? document.body.parentElement.scrollTop : 0;
   }

  ampliacionCont.appendChild(ampliacion);
  document.body.appendChild(ampliacionCont);
  var ancho_v = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth;
  var alto_v = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight;
  ampliacionCont.style.left = (ancho_v/2 - ampliacionCont.offsetWidth/2)+'px'//ScrollTop+'px';
  ampliacionCont.style.top = (alto_v/2 - ampliacionCont.offsetHeight/2 + ScrollTop)+'px'//ScrollTop+'px';
  ampliacionCont.style.visibility = 'visible';
 }

function tipoNavegacion(navegacion, indice)
 {
  var navChilds = navegacion.childNodes;
  for(var i = 0; i < navChilds.length; i++)
   {
	navChilds[i].className = (indice == i) ? 'activo' : '';
   }
  if(indice == 0)
   {
	Codigo = null;
	obtenerItems();
   }
  else
   {
	var cod = document.getElementById('codigo');
	cod.value = '';
	cod.focus();
   }
 }

function estiloSelectores()
 {
  var conts = document.getElementById('porcategorias').getElementsByTagName('span');
  var tabla, fila, celda, span;
  for(var i = 0; i < conts.length; i++)
   {
	span = conts[i];
	tabla = document.createElement('table');
	tabla.className = 'fondoSelector';
	tabla.id = "selFondo";
	fila = tabla.insertRow(0);
	celda = fila.insertCell(0);
	celda.className = "n";
	celda = fila.insertCell(1);
	celda.className = "e";
	span.insertBefore(tabla, span.firstChild);
   }
 }

function actSelEstilo(selector)
 {
  selector.previousSibling.rows[0].cells[0].innerHTML = selector.options[selector.selectedIndex].text;
 }
