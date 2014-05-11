agregarEvento = function(elemento, evento, funcion)
 {
  if(typeof elemento == "string")
	elemento = document.getElementById(elemento);
  if(elemento == null)
	return;
  if(elemento.addEventListener)
	elemento.addEventListener(evento, funcion, true);
  else if(elemento.attachEvent)
   {
	elemento.attachEvent('on'+evento, funcion);
   }
  else
	elemento["on" + evento] = funcion;
 };

function XHR()
 {
  var xhr;
  if(window.XMLHttpRequest && !(window.ActiveXObject))
   {
    xhr = new XMLHttpRequest();
   }
  else if(window.ActiveXObject)
   {
    try
	 {
      xhr = new ActiveXObject("Msxml2.XMLHTTP");
     }
	catch(e)
	 {
      try
	   {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
       }
	  catch(e)
	   {
        return false;
       }
	 }
   }
  return xhr;
 }

function trim(cadena)
 {
  return cadena.replace(/^\s*|\s*$/g,"");
 }
