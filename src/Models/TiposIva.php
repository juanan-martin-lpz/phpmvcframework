<?php

namespace GestionComercial\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


use GestionComercial\Models\ModelBase as Base;

class Tipos_Iva extends Base {


    private $idtipo_iva;
    private $descripcion_tipo_iva;
    private $tipo_iva;

    public function save() {

        if ($idtipo_iva == null || $idtipo_iva == 0) {
            // Nuevo registro
            Database::connect();
            $cnx = Database::getConnection();

            $sql = "INSERT INTO TIPOS_IVA (descripcion_tipo_iva, tipo_iva) VALUES(:descripcion_tipo_iva, :tipo_iva)";

            $stmt = $cnx->prepare($sql);

            $stmt->bindParam(':descripcion_tipo_iva', $this->descripcion_tipo_iva);
            $stmt->bindParam(':tipo_iva', $this->tipo_iva, PDO::PARAM_INT);

            return $stmt->execute();
        }
        else {
            // Modificacion

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
