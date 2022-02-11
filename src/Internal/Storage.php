<?php

namespace MVCLite\Internal;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

/**
 * Clase estatica para interactuar con el deposito de Cookies
 *
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class Storage {

    /**
     * Metodo para leer un cookie por su clave
     *
     * @param string $key La clave a recuperar
     *
     * @return string El valor recuperado o null
     *
     * @api
     */
    public static function  getValue($key) {
        return $_COOKIE[$key];
    }

    /**
     * Metodo para escribir una cookie por medio de una clave
     *
     * @param string $key La clave a usar
     * @param string $value El valor a almacenar
     *
     * @api
     */

    public static function setValue($key, $value) {
        setcookie($key, $value, time() + 3600, '/');
    }

    /**
     * Metodo para eliminar una cookie por medio de una clave
     *
     * @param string $key La clave a usar
     * @param string $value El valor a eliminar
     *
     * @api
     */

    public static function deleteKey($key) {
        setcookie($key, null, time() - 1000, '/');
    }

}

?>
