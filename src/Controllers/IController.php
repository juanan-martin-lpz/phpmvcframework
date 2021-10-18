<?php

namespace GestionComercial\Controllers;

require '../vendor/autoload.php';

interface IController {
    public function doGet($request);
    public function doPost($request);
}
?>
