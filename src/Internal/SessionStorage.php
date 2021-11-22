<?php

namespace GestionComercial\Internal;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Clase estatica para interactuar con el deposito de cookies de sesion
 *
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class SessionStorage {


    /**
     * Metodo para leer una cookie de sesion por su clave
     *
     * Si la sesion esta activa, devuelve el valor referenciado por la clave pasada com parametro
     *
     * @api
     */
    public static function  getValue($key) {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return $_SESSION[$key];
        }
    }

    /**
     * Metodo para escribir una cookie de sesion por medio de una clave
     *
     * Si la sesion esta activa realiza la escritura del valor pasado en la clave pasada como parametro
     *
     * @api
     */

    public static function setValue($key, $value) {

        if (session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION[$key] = $value;
        }

    }
}

?>
