<?php

class Pedidos extends ModelBase {


    private int $idpedido;
    private int $idcliente;
    private int $idforma_pago;
    private int $idtipo_iva;
    private DateTime $fecha_pedido;
    private float $dto_comercial;

    private array $lineasPedido = [];

    public function save() {

    }

    public function delete() {

    }

    public function getIdPedido() {
        return $this->idpedido;
    }

    public function getIdCliente() {
        return $this->idcliente;
    }

    public function getIdFormaPago() {
        return $this->idforma_pago;
    }

    public function getIdTipoIVA() {
        return $this->idtipo_iva;
    }

    public function getFechaPedido() {
        return $this->fecha_pedido;
    }

    public function getDtoComercial() {
        return $this->dto_comercial;
    }

    public function setIdPedido(int $pedido) {
        $this->idpedido = $pedido;
    }

    public function setIdCliente(int $cliente) {
        $this->idcliente = $cliente;
    }

    public function setIdFormaPago(int $formap) {
        $this->idforma_pago = $formap;
    }

    public function setIdTipoIva(int $tipoi) {
        $this->idtipo_iva = $tipoi;
    }

    public function setFechaPedido(DateTime $fecha) {
        $this->fecha_pedido = $fecha;
    }

    public function setDtoComercial(float $dto) {
        $this->dto_comercial = $dto;
    }

    public function getLineasPedido() {
        return $this->lineasPedido;
    }

    public function setLineasPedido($lineasPedido) {
        $this->lineasPedido = $lineasPedido;
    }

}

?>
