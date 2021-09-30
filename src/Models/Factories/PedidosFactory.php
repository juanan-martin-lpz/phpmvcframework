<?php

//include_once "../Pedidos.php";

class PedidoFactory implements IConcreteModelFactory {

    public static function fromAssoc($data) : Pedidos {

        // Aqui construimos una instancia a medida, usando setters o lo que nos de la gana
        // Si la clase tiene objetos dependientes se pueden crear tambien por aqui
        $obj = new Pedidos();
        $obj->setIdPedido($data['idpedido']);
        $obj->setIdCliente($data['idcliente']);
        $obj->setIdFormaPago($data['idforma_pago']);
        $obj->setIdTipoIva($data['idtipo_iva']);
        $obj->setFechaPedido( new DateTime($data['fecha_pedido']));
        $obj->setDtoComercial((float) $data['dto_comercial']);

        // Retornamos la clase recien creada
        return $obj;
    }

    public static function create() : Pedidos {
        return new Pedidos();
    }

}

?>
