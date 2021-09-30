<?php

require 'Controllers/RequestDispatcher.php';
require 'Controllers/DefaultRouter.php';
require 'Controllers/PedidosController.php';

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

// Crear las rutas de la aplicacion, requiere de los controladores especificos, pero solo haremos un require_once
$router = new DefaultRouter();

$router->add('/src/pedidos', new PedidosController());

// Creamos el dispatcher
$dispatcher = new RequestDispatcher($router);

// Despachamos
echo $dispatcher->dispatch();


// Limpieza
?>
