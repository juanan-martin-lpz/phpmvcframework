<?php

require 'Database.php';
require 'DatabaseConfig.php';
require 'IConcreteModelFactory.php';

abstract class ModelBase {

    //private static $connection = null;

    protected string $tablename;

    //private static ?DatabaseConfig $config = null;


    /*
      Abrimos la conexion
    */
    /*
    protected static function connect() {

        // De donde sacamos los params???

        if (self::$config != null ) {

            //self::$connection = mysqli_connect(self::$config->host, self::$config->user, self::$config->password, self::$config->databasename, self::$config->port );

            self::$connection = new PDO( self::$config->driver . ':host=' . self::$config->host . ';port=' . self::$config->port . ';dbname=' . self::$config->databasename,  self::$config->user, self::$config->password);

            if (!self::$connection) {

                die("Error al conectar : " . mysqli_error(self::$connection));
            }

        }
        else {
            return false;
        }
    }
    */
    /*
      Cerramos la conexion
    */
    /*
    protected static function close() {

        self::$connection = null;

    }

    */

    /*
      Retornamos todos los registros en forma de array de objetos del tipo de la clase llamadora
      Recibe una clase de factoria implementando el interfec IConcreteModelFactory
      No podemos tipar el parametro por que esperaria una instancia de la clase y tan solo tiene metodos estaticos
      aunque comprobamos su tipo y si no coinciden saltamos.
    */
    public static function findAll( $factory = null) {

        if (!gettype($factory) == 'IConcreteModelFactory' && $factory != null) {
            throw new Exception("La factoria no es del tipo esperado");
        }

        $sql = "SELECT * FROM " . strtoupper(get_called_class()) . ';';

        $result = Database::query($sql, $factory);

        /*
        // conectar
        self::connect();

        // ejecutar
        $stmt = self::$connection->query($sql);

        $result = [];


        // Recuperamos los registros uno a uno y creamos un array de objetos
        // Pudiera llegar a ser lento si hay muchas filas a devolver

        if ($factory) {
            while($obj = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $result[] = $factory::fromAssoc($obj);
            }
        }
        else {
            while($obj = $stmt->fetchObject()) {

                $result[] = $obj;
            }
        }

        // cerrar
        self::close();
        */

        // devolver
        return $result;

    }

    private function findAllGenericObjects() {

    }

    private static function findAllWithFactory($factory) {


    }

    public static function findById(int $id) {

    }

    public static function findByPred(string $predicate) {

    }

    abstract public function save();

    abstract public function delete();

    public function getTableName() {
        return $this->tablename;
    }

    public function setTableName(string $tablename) {
        if ($tablename != '') {
            $this->tablename = $tablename;
        }
    }

    /*
    public static function setDatabaseConfig(DatabaseConfig $config) {

        if ($config == null) {
            die("Configuracion de base de datos invalida");
        }
        else {
            self::$config = $config;
        }
    }

    public static function getDatabaseConfig() {
        return self::$config;
    }
    */
}
?>
