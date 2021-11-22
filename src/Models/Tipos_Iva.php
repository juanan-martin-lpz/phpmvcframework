<?php

namespace GestionComercial\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


use GestionComercial\Models\ModelBase as Base;

class Tipos_Iva extends Base {


    private $idtipo_iva;
    private $descripcion_tipo_iva;
    private $tipo_iva;

    public function save() {

        $sql = "";
        $params = [];

        if ($this->idtipo_iva == null || $this->idtipo_iva == 0) {
            // Nuevo registro
            $sql = "INSERT INTO TIPOS_IVA (descripcion_tipo_iva, tipo_iva) VALUES(:descripcion_tipo_iva, :tipo_iva)";

        }
        else {
            // Modificacion
            $sql = "UPDATE TIPOS_IVA  SET descripcion_tipo_iva = :descripcion_tipo_iva, tipo_iva = :tipo_iva WHERE idtipo_iva = :idtipo_iva";

            $params[':idtipo_iva'] = [$this->idtipo_iva, \PDO::PARAM_INT];
        }

        $params[':descripcion_tipo_iva'] = [$this->descripcion_tipo_iva, \PDO::PARAM_STR];
        $params[':tipo_iva'] = [$this->tipo_iva, \PDO::PARAM_INT];

        try {
            return Database::execute($sql, $params);
        }
        catch (\PDOException $ex) {
            echo $ex->getMessage();
            throw($ex);
        }

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

    public function setIdTipoIva($tipo) {
        $this->idtipo_iva = $tipo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion_tipo_iva = $descripcion;
    }

    public function setTipoIva($tipo) {
        $this->tipo_iva = $tipo;
    }

}

?>
