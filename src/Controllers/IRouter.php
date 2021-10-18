<?php

namespace GestionComercial\Controllers;

require '../vendor/autoload.php';

require 'IController.php';

interface IRouter {
    public function add(string $route, IController $controller);
    public function route($request);
}
?>
