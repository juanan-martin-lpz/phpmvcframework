<?php

namespace GestionComercial\Controllers\Actions\TiposIva;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Controllers as Core;
use GestionComercial\Views\Mantenimientos as Vistas;

use GestionComercial\Models as Models;

class TiposIvaDefaultAction implements Core\IAction {

    private $view;
    private $data;

    public function __construct() {
    }

    public function execute($data = null): string {

        $this->data['tiposiva'] = Models\Tipos_Iva::findAll();

        // Creamos la vista y le pasamos los datos
        $this->view = new Vistas\TiposIvaDefaultView($this->data);

        $this->view->loadHTML();

        // Retornamos la vista
        return $this->view->render();

    }
}


?>
