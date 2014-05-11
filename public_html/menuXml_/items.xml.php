<?php

$redir = substr($_SERVER['REQUEST_URI'], 1);
header("Location: /_".$redir);
exit(" ");

?>