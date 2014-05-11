var precios = {};

function Pedido()
 {
  this.subtotales = [{},{}];// 0 reman - 1 nuevo
  this.iva = 0.16;
  this.subtotal = 0;
  this.currIva = 0;
 }

Pedido.prototype.Agregar = function(id, tipo, cantidad)
 {
  if(this.subtotales[tipo][id] == null)
	this.subtotales[tipo][id] = [0, 0];
  this.subtotales[tipo][id][0] = cantidad;
  this.subtotales[tipo][id][1] = (precios[id][tipo] * cantidad);
 }

Pedido.prototype.Quitar = function(id, tipo)
 {
  this.subtotales[tipo][id] = null;
 }

Pedido.prototype.SubTotalItem = function(id, tipo)
 {
  return this.subtotales[tipo][id] ? this.precioFormato(this.subtotales[tipo][id][1]) : ' ';
 }

Pedido.prototype.Activo = function(id)
 {
  return (this.subtotales[0][id] != null || this.subtotales[1][id] != null);
 }

Pedido.prototype.SubTotal = function()
 {
  this.subtotal = 0;
  for(var i = 0; i < 2; i++)
   {
	for(var j in this.subtotales[i])
	 {
	  if(this.subtotales[i][j] == null)
		continue;
	  this.subtotal += this.subtotales[i][j][1];
	 }
   }
  return this.precioFormato(this.subtotal);
 }

Pedido.prototype.Impuestos = function()
 {
  this.currIva = (this.subtotal * this.iva)
  return this.precioFormato(this.currIva);
 }

Pedido.prototype.Total = function()
 {
  return this.precioFormato(this.currIva + this.subtotal);
 }

Pedido.prototype.precioFormato = function(num)
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

function validarNum(event)
 {
  if(event.charCode == 0)
	return true;
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
  return numcheck.test(keychar);
 }

function calcularTotal(cantidad, id, tipo) // tipo: 0 reman - 1 nuevo
 {
  //var cantidad = campo;//.value;
  if(cantidad >= 1)
	pedido.Agregar(id, tipo, cantidad)
  else
	pedido.Quitar(id, tipo);

  //campo.parentNode.parentNode.className = pedido.Activo(id) ? 'activo' : '';
  document.getElementById("fila_"+id).className = pedido.Activo(id) ? 'activo' : '';
  //campo.nextSibling.innerHTML = pedido.SubTotalItem(id, tipo);
  document.getElementById("it_"+id+"_"+tipo).innerHTML = pedido.SubTotalItem(id, tipo);
  document.getElementById("subtotal").innerHTML = pedido.SubTotal();
  document.getElementById("curr_iva").innerHTML = pedido.Impuestos();
  document.getElementById("total").innerHTML = pedido.Total();
 }

window['onload'] = function()
 {
  document.forms[0].reset();
  document.getElementById('totales').style.left = (document.getElementById('planilla').scrollWidth + 15)+'px';
 }
