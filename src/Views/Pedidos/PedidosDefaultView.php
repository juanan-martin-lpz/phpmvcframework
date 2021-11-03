<?php

namespace GestionComercial\Views\Pedidos;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Views as Core;

class PedidosDefaultview extends Core\View {

    public function __construct($data = null, $parser = null) {
        parent::__construct($data, $parser);
    }

    public function render(): string {

        return "Hola desde la accion PedidosDefaultAction";

    }
}
?>
