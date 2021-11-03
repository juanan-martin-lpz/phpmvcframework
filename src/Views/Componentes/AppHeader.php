<?php

namespace GestionComercial\Views\Componentes;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Views\ComponentBase as Component;


class AppHeader extends Component {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function loadHTML() {

        $this->html = file_get_contents('Views/Componentes/html/appheader.html');

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
