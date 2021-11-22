<?php

namespace GestionComercial\Controllers\Actions\TiposIva;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Controllers as Core;
use GestionComercial\Views\Mantenimientos as Vistas;

use GestionComercial\Models as Models;

class TiposIvaNewAction implements Core\IAction {

    private $view;
    private $data;

    public function __construct() {
    }

    public function execute($data = null): string {

        // Creamos la vista y le pasamos los datos
        $this->view = new Vistas\TiposIvaNewView($data);

        $this->view->loadHTML();

        // Retornamos la vista
        return $this->view->render();

    }
}


?>
