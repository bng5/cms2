<?php

$path = explode("/", trim($_SERVER['PATH_INFO'], " /"));

print_r($path);
?>