<?php

require 'DatabaseConfig.php';
require 'IConcreteModelFactory.php';

abstract class ModelBase {

    private static $connection = null;

    private static ?DatabaseConfig $config = null;

    /*
      Abrimos la conexion
    */
    protected static function connect() {

        // De donde sacamos los params???

        if (self::$config != null ) {

            self::$connection = mysqli_connect(self::$config->host, self::$config->user, self::$config->password, self::$config->databasename, self::$config->port );

            if (!self::$connection) {

                print_r(self::$config);

                die("Error al conectar : " . mysqli_error(self::$connection));
            }

        }
        else {
            return false;
        }
    }

    /*
      Cerramos la conexion
    */
    protected static function close() {

        if (self::$connection) {
            self::$connection->close();
        }
    }


    /*
      Retornamos todos los registros en forma de array de objetos del tipo $entityname
    */
    public static function findAll($factory) {

        $sql = "SELECT * FROM " . strtoupper(get_called_class()) . ';';

        // conectar
        self::connect();
        // ejecutar
        $dataset = self::$connection->query($sql);

        $result = [];

        // Aqui deberiamos crear instancias de la clase concreta
        // Maybe...pasandole un array assoc con los campos??
        // Y si no lo implementa???
        // Una factoria???? Seria lo mas adecuado, pero...como le pasamos la factoria???

        while($obj = $dataset->fetch_assoc()) {

            $result[] = $factory::fromAssoc($obj);
        }

        // cerrar
        self::close();

        // devolver
        return $result;
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

    public function getEntityName() {
        return $this->entityname;
    }

    public function setTableName(string $tablename) {
        if ($tablename != '') {
            $this->tablename = $tablename;
        }
    }

    public function setEntityName(string $entityname) {
        if ($tablename != '') {
            $this->entityname = $entityname;
        }
    }

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
}
?>
