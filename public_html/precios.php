<?php

include('../inc/iniciar.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es-uy" lang="es-uy">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
 <title><?= SITIO_TITULO ?></title>
 <link rel="stylesheet" href="/css/eps/planilla.css" />
 <script type="text/javascript" src="/js/eps/pedido.js" charset="utf-8"></script>
</head>
<body>

<?php


if($_SESSION['usuario_id'])
 {
  if($planilla = EPSModelo_UsuariosUltPlanilla::Listado($_SESSION['usuario_id']))
   {
    //Impressores
    echo '
 <h1>'.($planilla->titulo ? $planilla->titulo : SITIO_TITULO.' S.L.').'</h1>
<form action="/confirmar_pedido" method="post">
 <div id="planilla_cont">
 <table id="planilla" class="eps_planilla">';

    if($planillaItems = $planilla->getIterator())
     {
	  $tipo = 0;
	  $js = '';
	  $tipos = array(1 => array("Tinta", "ml"), 2 => array("Tóner", "Págs."));
	  foreach($planillaItems AS $v)
       {
		if($v->tipo != $tipo)
		 {
		  $tipo = $v->tipo;
		  echo ($tbody ? '<tr><td colspan="6" class="sep"></td></tr></tbody>' : '').'
  <tbody class="'.($tipo == 1 ? 'tinta' : 'toner').'">
   <tr>
    <th>Marca</th><th>Tipus</th><th>'.$tipos[$tipo][0].'</th><th>'.$tipos[$tipo][1].'</th><th colspan="2" class="reman">Re Manufacturado</th><th colspan="2">Original</th></tr>';
		  $tbody = true;
		 }
		$js .= 'precios['.$v->id.'] = ['.($v->precio_reman ? $v->precio_reman : 'null').', '.($v->precio_nuevo ? $v->precio_nuevo : 'null').'];
';
	    echo '
   <tr id="fila_'.$v->id.'" '.($_SESSION['pedido'][$v->id] ? ' class="activo"':'').'>
    <td>'.$v->marca.'</td><td>'.$v->modelo.'</td><td>'.$v->insumo.'</td><td class="rendimiento">'.$v->getRendimiento().'</td><td class="precio reman">'.($v->precio_reman ? '<span>€ '.$v->getPrecioReman().'</span></td><td class="precio subtotal">x<input type="text" size="2" name="pedido[0]['.$v->id.']" value="'.$_SESSION['pedido'][$v->id][0].'" maxlength="4" onkeypress="return validarNum(event)" onkeyup="calcularTotal(this.value, '.$v->id.', 0)" /><span id="it_'.$v->id.'_0"> </span>' : ' </td><td class="precio subtotal"> ').'</td><td class="precio nuevo">'.($v->precio_nuevo ? '<span>€ '.$v->getPrecioNuevo().'</span></td><td class="precio subtotal">x<input type="text" size="2" name="pedido[1]['.$v->id.']" value="'.$_SESSION['pedido'][$v->id][1].'" maxlength="4" onkeypress="return validarNum(event)" onkeyup="calcularTotal(this.value, '.$v->id.', 1)" /><span id="it_'.$v->id.'_1"> </span>' : ' </td><td class="precio subtotal"> ').'</td>
   </tr>';
	   }
     }
	echo ($tbody ? '</tbody>' : '')."
 </table>

</div>
";
   }
 }

?>

  <div id="totales">
   <ul>
    <li><label>Sub-Total: </label><span id="subtotal"> </span></li>
    <li><label>IVA: </label><span id="curr_iva"> </span></li>
    <li><label>Total: </label><span id="total"> </span></li>
   </ul>
   <p><input type="submit" value="Enviar pedido" /></p>
  </div>
 </form>
<script type="text/javascript">

var pedido = new Pedido();

<?= $js ?>

<?php

if($_SESSION['pedido'] && is_array($_SESSION['pedido']))
 {
  foreach($_SESSION['pedido'] AS $k => $v)
   {
    if($v[0])
	  echo "calcularTotal(".$v[0].", ".$k.", 0);\n";
    if($v[1])
	  echo "calcularTotal(".$v[1].", ".$k.", 1);\n";
   }
 }

?>

</script>
</body>
</html>