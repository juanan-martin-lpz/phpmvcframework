<?php

//require 'Controllers/RequestDispatcher.php';
//require 'Controllers/DefaultRouter.php';
//require 'Controllers/PedidosController.php';

namespace GestionComercial;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\CL\Parser\ComponentRegistry as Registry;
use GestionComercial\Models\DatabaseConfig as Config;
use GestionComercial\Models\Database as DB;

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

$cfg = Config::fromJSON('Config/dbconfig.json');
DB::setDatabaseConfig($cfg);

require $_SERVER['DOCUMENT_ROOT'] . '/registerComponents.php';


// Crear las rutas de la aplicacion, requiere de los controladores especificos, pero solo haremos un require_once
$router = new Controllers\DefaultRouter();
//

$router->add('/tiposiva', new Controllers\TiposIvaController(/* $parser */));

// Creamos el dispatcher
$dispatcher = new Controllers\RequestDispatcher($router);

// Despachamos
echo $dispatcher->dispatch();

// Limpieza
?>
