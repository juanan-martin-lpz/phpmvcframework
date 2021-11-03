<?php

namespace GestionComercial\Views\Mantenimientos;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


class TiposIva extends ComponentBase {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function loadHTML() {

        $this->html = "";

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
