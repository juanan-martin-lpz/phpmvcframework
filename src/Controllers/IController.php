<?php

namespace GestionComercial\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

interface IController {
    public function doGet($request);
    public function doPost($request);
}
?>
