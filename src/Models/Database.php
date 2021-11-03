<?php

namespace GestionComercial\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class Database {

    private static $connection = null;

    private static ?DatabaseConfig $config = null;

    public static function connect() {

        if (self::$config != null ) {

            self::$connection = new \PDO( self::$config->driver . ':host=' . self::$config->host . ';port=' . self::$config->port . ';dbname=' . self::$config->databasename,  self::$config->user, self::$config->password);

            if (!self::$connection) {

                die("Error al conectar : " . mysqli_error(self::$connection));
            }

        }
        else {
            return false;
        }
    }

    public static function close() {

        self::$connection = null;

    }

    public static function query(string $sql, $factory = null) {
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

        // devolver
        return $result;

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
