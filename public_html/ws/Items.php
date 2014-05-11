<?php
// Pull in the NuSOAP code
require_once('../../inc/iniciar.php');
require_once('nusoap/nusoap.php');
// Create the server instance
$server = new soap_server();
// Initialize WSDL support
$server->configureWSDL('items', 'urn:items');
// Register the data structures used by the service


$mysqli = BaseDatos::Conectar();
$server->wsdl->addComplexType(
    'Item',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'firstname' => array('name' => 'firstname', 'type' => 'xsd:string'),
        'age' => array('name' => 'age', 'type' => 'xsd:int'),
        'gender' => array('name' => 'gender', 'type' => 'xsd:string')
    )
);
// 'xsd:boolean'


  if(!$resultado = $mysqli->query("SELECT * FROM `pub__${seccion}` LIMIT 1")) error("No existe ninguna publicación para la sección indicada.");
  if($finfo = $resultado->fetch_fields())
   {
	$campos = array();
	foreach ($finfo as $val)
	 {
	  $ex = explode("__", $val->name);
	  if($ex[1]) $campos[$ex[1]][$ex[0]] = "{$ex[0]}__{$ex[1]}";
	 }
	$resultado->close();
   }

print_r($campos);
exit;


$server->wsdl->addComplexType(
    'Secciones',
    'complexType',
    'struct',
    'all',
    '',
    array(
		'id' => array('name' => 'id', 'type' => 'xsd:string'),
		'nombre' => array('name' => 'nombre', 'type' => 'xsd:string'),
		'tipo' => array('name' => 'tipo', 'type' => 'xsd:string'),
		'icono' => array('name' => 'icono', 'type' => 'xsd:string'),
		'info' => array('name' => 'info', 'type' => 'xsd:boolean'),
		'items' => array('name' => 'items', 'type' => 'xsd:boolean'),
		'categorias' => array('name' => 'categorias', 'type' => 'xsd:boolean'),
		'rss' => array('name' => 'rss', 'type' => 'xsd:boolean')
    )
);

// Register the method to expose
$server->register('hello',                    // method name
    array('person' => 'tns:Person'),          // input parameters
    array('return' => 'tns:SweepstakesGreeting'),    // output parameters
    'urn:hellowsdl2',                         // namespace
    'urn:hellowsdl2#hello',                   // soapaction
    'rpc',                                    // style
    'encoded',                                // use
    'Greet a person entering the sweepstakes'        // documentation
);

// Register the method to expose
$server->register('VerSecciones',                    // method name
    array(),          // input parameters
    array('return' => 'tns:Secciones'),    // output parameters
    'urn:hellowsdl2',                         // namespace
    'urn:hellowsdl2#hello',                   // soapaction
    'rpc',                                    // style
    'encoded',                                // use
    'Greet a person entering the sweepstakes'        // documentation
);

// Define the method as a PHP function
function hello($person)
 {
  $greeting = 'Hello, ' . $person['firstname'] .
                '. It is nice to meet a ' . $person['age'] .
                ' year old ' . $person['gender'] . '.';

  $winner = $person['firstname'] == 'Scott';

  return array(
                'greeting' => $greeting,
                'winner' => $winner
         );
 }

class Seccion
 {
  var $id = "";
  var $nombre = "";
  var $tipo = "";
  var $icono = "";
  var $info = "";
  var $items = false;
  var $categorias = false;
  var $rss = false;
  var $secciones = array();
 }

function VerSecciones()
 {
	$obj = new stdClass();
	$obj->leng = "es";
	$obj->secciones = array();
	$obj->secciones[0] = new Seccion();
	$obj->secciones[0]->id = "productos";
	$obj->secciones[0]->nombre = "CHIMENEAS";
	$obj->secciones[0]->items = true;
	$obj->secciones[0]->categorias = true;

	$obj->secciones[1] = new Seccion();
	$obj->secciones[1]->id = "tecnologia";
	$obj->secciones[1]->nombre = "FUNCIONAMIENTO";
	$obj->secciones[1]->items = true;
	$obj->secciones[1]->categorias = true;

	$obj->secciones[2]->id = "contacto";
	$obj->secciones[2]->nombre = "CONTACTO";
	$obj->secciones[2]->info = true;

	$obj->secciones[3] = new Seccion();
	$obj->secciones[3]->id = "energia";
	$obj->secciones[3]->nombre = "BIOETANOL";
	$obj->secciones[3]->items = true;
	$obj->secciones[3]->categorias = true;

	$obj->secciones[4] = new Seccion();
	$obj->secciones[4]->id = "seguridad";
	$obj->secciones[4]->nombre = "SEGURIDAD";
	$obj->secciones[4]->items = true;
	$obj->secciones[4]->categorias = true;

	$obj->secciones[5] = new Seccion();
	$obj->secciones[5]->id = "distribuidores";
	$obj->secciones[5]->nombre = "DISTRIBUIDORES";

	$obj->secciones[5]->secciones[0] = new Seccion();
	$obj->secciones[5]->secciones[0]->id = "puntos_de_venta";
	$obj->secciones[5]->secciones[0]->nombre = "Puntos de venta";
	$obj->secciones[5]->secciones[0]->items = true;
	$obj->secciones[5]->secciones[0]->categorias = true;

	$obj->secciones[5]->secciones[1] = new Seccion();
	$obj->secciones[5]->secciones[1]->id = "como_ser_distribuidor";
	$obj->secciones[5]->secciones[1]->nombre = "¿Quiere ser distribuidor?";
	$obj->secciones[5]->secciones[1]->info = true;

	$obj->secciones[6] = new Seccion();
	$obj->secciones[6]->id = "faq";
	$obj->secciones[6]->nombre = "FAQ";
	$obj->secciones[6]->items = true;
	$obj->secciones[6]->categorias = true;

	$obj->secciones[7] = new Seccion();
	$obj->secciones[7]->id = "home";
	$obj->secciones[7]->nombre = "HOME";
	$obj->secciones[7]->info = true;
	$obj->secciones[7]->items = true;
  return $obj;
 }

$fp = fopen("php://input", "r");
$data = '';
while(!feof($fp))
    $data .= fgets($fp);
fclose($fp);
$server->service($data);

?>