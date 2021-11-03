<?php

namespace GestionComercial\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


use GestionComercial\Models\ModelBase as Base;

class Tipos_Iva extends Base {


    private int $idtipo_iva;
    private int $descripcion_tipo_iva;
    private int $tipo_iva;

    public function save() {

    }

    public function delete() {

    }

    public function getIdTipoIva() {
        return $this->idtipo_iva;
    }

    public function getDescripcion() {
        return $this->descripcion_tipo_iva;
    }

    public function getTipoIva() {
        return $this->tipo_iva;
    }

    public function setIdTipoIva(int $tipo) {
        $this->idtipo_iva = $tipo;
    }

    public function setDescripcion(int $descripcion) {
        $this->descripcion_tipo_iva = $descripcion;
    }

    public function setTipoIva(int $tipo) {
        $this->tipo_iva = $tipo;
    }

}

?>
