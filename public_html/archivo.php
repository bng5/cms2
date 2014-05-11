<?php

require_once('../inc/iniciar.php');

if ($archivo = explode("/", trim($_SERVER['PATH_INFO'], "/ "))) {
    $mysqli = BaseDatos::Conectar();
    $cons = $mysqli->query("SELECT archivo, nombre, formato, peso, UNIX_TIMESTAMP(fecha) AS fecha, hash FROM archivos WHERE id = '{$archivo[0]}' LIMIT 1");
    if ($fila = $cons->fetch_assoc()) {
        if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $fila['fecha'] || trim($_SERVER['HTTP_IF_NONE_MATCH']) == $fila['hash']) {
            header('Etag: ' . $fila['hash'], true, 304);
            exit;
        }
        header('Last-Modified: ' . date("r", $fila['fecha']));
        header('Etag: ' . $fila['hash']);
        header('Content-Type: ' . $fila['formato']);
        header('Content-Length: ' . $fila['peso']);
        header('Content-Disposition: inline; filename="' . $fila['nombre'] . '"');
        //header('Content-Disposition: attachment; filename="'.$fila['nombre'].'"');
        readfile("./archivos/{$fila['archivo']}");
        exit;
    }
    $cons->close();
}

header('Content-type: text/plain; charset=utf-8', true, 404);
echo "No se encontró el archivo solicitado.";

?>