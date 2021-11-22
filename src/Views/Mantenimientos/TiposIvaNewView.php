<?php

namespace GestionComercial\Views\Mantenimientos;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Views\ComponentBase as Component;

class TiposIvaNewView extends Component {

    public function __construct($data) {

        parent::__construct($data);
    }

    public function loadHTML() {

        $this->html = file_get_contents('Views/Mantenimientos/html/nuevotipoiva.html');

        $this->dom = $this->intepretDOM();

        return $this->dom;
    }

    public function render(): string {

        $this->html = $this->dom->saveHTML($this->dom);

        return $this->html;
    }

}
?>
