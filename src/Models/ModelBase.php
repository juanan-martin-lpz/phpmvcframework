<?php

//require 'Database.php';
//require 'DatabaseConfig.php';
//require 'IConcreteModelFactory.php';

namespace MVCLite\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


/**
 * Clase base para los Modelos de datos
 *
 * Contiene una mezcla de metdodos estaticos y metodos de instancia para su extension en las clases
 * hijas, que seran las que concreten un determinado Modelo de datos
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 * @todo Conciliar el nombre de la tabla dado por el usuario y el metodo findAll, que usa el nombre de la clase.
 * @todo Metodo findById
 * @todo Metodo findByPred
 *
 */

abstract class ModelBase {

    protected string $tablename;     // Nombre de la tabla, por defecto sera el de la clase.

    /*
      Retornamos todos los registros en forma de array de objetos del tipo de la clase llamadora
      Recibe una clase de factoria implementando el interfec IConcreteModelFactory
      No podemos tipar el parametro por que esperaria una instancia de la clase y tan solo tiene metodos estaticos
      aunque comprobamos su tipo y si no coinciden saltamos.
    */

    /**
     * Recupera todos los registro de la tabla
     *
     * Retornamos todos los registros en forma de array de objetos del tipo de la clase llamadora
     * Recibe una clase de factoria implementando el interfec IConcreteModelFactory
     * No podemos tipar el parametro por que esperaria una instancia de la clase y tan solo tiene metodos estaticos
     * aunque comprobamos su tipo y si no coinciden saltamos.
     *
     * @param IConcreteModelFactory $factory Una instancia de Factoria de datos
     *
     * @return Array Retorna un array de objetos con todos los registros de la
     *
     * @api
     */

    public static function findAll( $factory = null) {

        if (!gettype($factory) == 'IConcreteModelFactory' && $factory != null) {
            throw new Exception("La factoria no es del tipo esperado");
        }

        $path = explode('\\', get_called_class());

        $tabla = end($path);

        $sql = "SELECT * FROM " . strtoupper($tabla) . ';';

        $result = Database::query($sql, $factory);

        // devolver
        return $result;

    }

    private function findAllGenericObjects() {

    }

    private static function findAllWithFactory($factory) {


    }

    /**
     * Recupera el registro de la tabla identificado con el id pasado
     *
     * @param int $id El id a buscar
     *
     * @return Object Retorna un objeto con el registro encontrado o null
     *
     * @api
     */

    public static function findById(int $id) {

    }


    public static function findByPred(string $predicate) {

    }

    /**
     * Funcion abstracta para gestionar el guardado del objeto
     *
     * @api
     */

    abstract public function save();

    /**
     * Funcion abstracta para gestionar el borrado del objeto
     *
     * @api
     */

    abstract public function delete();

    public function getTableName() {
        return $this->tablename;
    }

    /**
     * Establece el nombre de la tabla
     *
     * @param string $tablename Nombre a usar en lugar del nombre de la clase
     *
     * @api
     */

    public function setTableName(string $tablename) {
        if ($tablename != '') {
            $this->tablename = $tablename;
        }
    }
}
?>
