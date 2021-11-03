<?php

namespace GestionComercial\Views\Componentes;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Views\ComponentBase as Component;


class BotonNuevo extends Component {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function loadHTML() {

        $this->html = "<a class='boton-nuevo' href='/tiposiva/new'>Nuevo</a>";

        $this->dom = $this->intepretDOM();

        return $this->dom;
    }

    public function render(): string {

        if (is_bool($n)) {
            return "";
        }

        $this->html = $this->dom->saveHTML($this->dom);

        return $this->html;
    }

}
?>
