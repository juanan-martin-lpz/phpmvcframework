<?php

namespace GestionComercial\CL\Parser\Contexts;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class ComponentContext implements IContext {

    private $data;
    private $name;

    public function __construct($name, $data) {

        $this->name = $name;
        $this->data = $data;

    }

    private function parseComponent() {

        // Crear una instancia del componente

        // parsear el resultado de llamar al metodo render del componente

        // retornar el resultado

    }

    public function getHtml(): string {

        return parseComponent();
    }
}
?>
