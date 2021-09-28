<?php


require '../src/Models/ModelBase.php';


class Pedidos extends ModelBase {


    private $idpedido;
    private $idcliente;


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

$config = new DatabaseConfig();

$config->host = 'localhost';
$config->port = 3306;
$config->user = 'root';
$config->password = 'Defender100';
$config->databasename = 'gestioncomercial';

$test = new Pedidos();

// Algo mejor que con un metodo de instancia
ModelBase::setDatabaseConfig($config);

// Comprobamos que se propaga la conexion a las instancias
var_dump(Pedidos::getDatabaseConfig());
echo '<br>';

var_dump(Albaranes::getDatabaseConfig());
echo '<br>';



// Hay que pasarle la clase
$result = Pedidos::findAll( 'PedidoFactory' );


foreach($result as $r) {
    var_dump($r);
}

?>
