<?php

namespace GestionComercial\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Implementacion estandar para el acceso a bases de datos via PDO
 *
 * Todos los metodos son estaticos asi como la conexion, que tiene una duracion equivalente a la vida de la aplicacion.
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class Database {

    private static $connection = null;     // Conexion. Se mantiene privada

    private static ?DatabaseConfig $config = null;    // Configuracion de acceso

    /**
     * Conexion con la base de datos
     *
     *
     * @return bool Retorna false si no dispone de una configuracion adecuada. Sale de la aplcacion si no puede obtener una conexion.
     *
     * @api
     */

    public static function connect() {

        if (self::$config != null ) {

            self::$connection = new \PDO( self::$config->driver . ':host=' . self::$config->host . ';port=' . self::$config->port . ';dbname=' . self::$config->databasename,  self::$config->user, self::$config->password);

            self::$connection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);

            if (!self::$connection) {

                die("Error al conectar : " . mysqli_error(self::$connection));
            }

        }
        else {
            return false;
        }
    }

    /**
     * Retorna la conexion
     *
     *
     * @return mixed La conexion con la base de datos
     *
     * @api
     */

    public static function getConnection() {
        if (self::$connection) {
            return self::$connection;
        }
        else {
            return null;
        }
    }

    public static function close() {

        self::$connection = null;

    }

    /**
     * Ejecuta una consulta contra la base de datos
     *
     * Si se le pasa una factoria retorna el resultado de procesar los registros con la factoria
     * Si no se le pasa una factoria, retorna un array de objetos con la estructura del registro
     *
     *
     * @param string $sql La consulta a ejecutar
     * @param Array $params Los parametros para la consulta
     * @param IConcreteModelFactory $factory Un objeto de Factoria
     *
     * @return Array Array de objetos con los registros recuperados
     *
     * @api
     */

    public static function query(string $sql, $params = null,  $factory = null) {
        // conectar
        self::connect();

        // ejecutar
        try {
            $stmt = self::$connection->prepare($sql);

            if ($params != null) {
                foreach($params as $k => $v) {
                    $stmt->bindParam($k, $v[0], $v[1]);
                }
            }

            $result = [];

            if ($stmt->execute()) {
                if ($factory) {
                    while($obj = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                        array_push($result, $factory::fromAssoc($obj));
                    }
                }
                else {
                    while($obj = $stmt->fetchObject()) {
                        array_push($result, $obj);
                    }
                }
            }

            return $result;
        }
        catch (\PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Ejecuta una sentencia DML contra la base de datos
     *
     *
     * @param string $sql La consulta a ejecutar
     * @param Array $params Los parametros para la consulta
     *
     * @return bool El resultado de la ejecucion
     *
     * @api
     */

    public static function execute(string $sql, $params = null) {
        // conectar
        self::connect();

        // ejecutar
        try {

            $stmt = self::$connection->prepare($sql);

            if ($params != null) {
                foreach($params as $k => $v) {
                    $stmt->bindParam($k, $v[0], $v[1]);
                }
            }

            return $stmt->execute();
        }
        catch (\PDOException $ex) {
            echo $ex->getMessage();
        }




    }

    /**
     * Establece la conexion para la conexion a traves de una instancia de DatabaseConfig
     *
     *
     * @param DatabaseConfig $config La configuracion a usar
     *
     * @api
     */

    public static function setDatabaseConfig(DatabaseConfig $config) {

        if ($config == null) {
            die("Configuracion de base de datos invalida");
        }
        else {
            self::$config = $config;
        }
    }

    /**
     * Retorna la configuracion de la base de datos actualmente usada
     *
     *
     * @return DatabaseConfig La configuracion de la conexion
     *
     * @api
     */

    public static function getDatabaseConfig() {
        return self::$config;
    }

}
?>
