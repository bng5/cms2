<?php

require_once('../../inc/iniciar.php');
header("Content-type: text/plain; charset=utf-8");//application/json
if(!$idiomas = @include('../../cms2/datos/idiomas.php'))
 {
  header("HTTP/1.1 500 Internal Server Error");
  echo '{"error" : true}';
  exit;
 }

echo json_encode($idiomas);

?>