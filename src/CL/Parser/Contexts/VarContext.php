<?php

namespace GestionComercial\CL\Parser\Contexts;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class VarContext implements IContext {

    private $data;
    private $name;

    public function __construct($data) {

        $this->data = $data;
    }

    public function setVarName($name) {
        $this->name = $name;
    }

    public function getHtml(): string {

        if (isset($this->data[$this->name])) {
            return $this->data[$this->name];
        }
        else {
            return "Error de Sintaxis: Variable no encontrada";
        }
    }
}
?>
