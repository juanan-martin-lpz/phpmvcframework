<?php

namespace GestionComercial\Controllers\Actions\Pedidos;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Controllers as Core;
use GestionComercial\Views\Pedidos as Vistas;

class PedidosDefaultAction implements Core\IAction {

    private $view;
    private $parser;

    public function __construct($parser = null) {
        $this->parser = $parser;
    }

    public function execute($data = null): string {

        // Creamos la vista y le pasamos los datos
        $this->view = new Vistas\PedidosDefaultView();

        // Retornamos la vista
        return $this->view->render();

    }
}


?>
