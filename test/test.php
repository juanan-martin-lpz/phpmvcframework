<?php


require '../src/Models/ModelBase.php';
require '../src/Models/Pedidos.php';
require '../src/Models/Factories/PedidosFactory.php';

/*
class Pedidos extends ModelBase {


    private int $idpedido;
    private int $idcliente;


    public function save() {

    }

    public function delete() {

    }


    public function setIdPedido(int $pedido) {
        $this->idpedido = $pedido;
    }

    public function setIdCliente(int $cliente) {
        $this->idcliente = $cliente;
    }

}

class PedidoFactory implements IConcreteModelFactory {

    public static function fromAssoc($data) : Pedidos {

        // Aqui construimos una instancia a medida, usando setters o lo que nos de la gana
        // Si la clase tiene objetos dependientes se pueden crear tambien por aqui
        $obj = new Pedidos();
        $obj->setIdPedido($data['idpedido']);
        $obj->setIdCliente($data['idcliente']);

        // Retornamos la clase recien creada
        return $obj;
    }

    public static function create() : Pedidos {
        return new Pedidos();
    }

}
*/


class Albaranes extends ModelBase {


    private $idalbaran;
    private $idcliente;

    public function __construct() {
        parent::__construct();
    }

    public function save() {

    }

    public function delete() {

    }


    public function setIdPedido(int $pedido) {
        $this->idpedido = $pedido;
    }

    public function setIdCliente(int $cliente) {
        $this->idcliente = $cliente;
    }
}


class AlbaranFactory implements IConcreteModelFactory {

    public static function fromAssoc($data) : Pedidos {

        // Aqui construimos una instancia a medida, usando setters o lo que nos de la gana
        // Si la clase tiene objetos dependientes se pueden crear tambien por aqui
        $obj = new Albaranes();
        $obj->setIdPedido($data['idalbaran']);
        $obj->setIdCliente($data['idcliente']);

        // Retornamos la clase recien creada
        return $obj;
    }

    public static function create() : Pedidos {
        return new Pedidos();
    }

}




// Configuramos el acceso a la base de datos
$config = DatabaseConfig::fromJSON('../src/Config/dbconfig.json');
Database::setDatabaseConfig($config);


// Buscamos todos los pedidos mediante factoria
$result = Pedidos::findAll( PedidoFactory::class );

echo 'Dataset con Factoria <br>';

foreach($result as $pedido) {

    echo $pedido->getIdPedido() . " - " . $pedido->getIdCliente() . " - " .  $pedido->getIdFormaPago() . "<br>";
}

// Si no se le pasa nos devuelve un array de objetos planos, con las propiedades con el mismo nombre de los campos
// Puede ser util para objetos u operaciones triviales
$result2 = Pedidos::findAll();

echo '<br>';

/*
echo 'Dataset con Factoria <br>';

foreach($result as $r) {
    var_dump($r);
}
*/

echo '<br>';

echo 'Dataset con Plain Objects <br>';

foreach($result2 as $pedido) {

    echo $pedido->idpedido . " - " . $pedido->idcliente . " - " .  $pedido->idforma_pago . "<br>";
}

/*
foreach($result2 as $r) {
    var_dump($r);
}
*/
?>
