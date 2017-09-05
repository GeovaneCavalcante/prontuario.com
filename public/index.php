<?php
// Se tu tivesse namepsace ja dava para usar
require_once "../vendor/autoload.php";

// Inicia aqui

$routes = new \App\Routes\Routes();
$routes->start();