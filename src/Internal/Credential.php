<?php

namespace GestionComercial\Internal;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Clase para interactuar con las credenciales de usuario
 *
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class Credential {

    private $tokenname; // Como se va a llamar el token en el deposito de sesion

    /**
     * Contructor
     *
     * Recibe el nombre de la clave que se usara para almacenar el token de usuario
     *
     * @param string $tokenname El nombre de la clave del token de usuario
     *
     * @api
     */

    public function __construct($tokenname) {

        $this->tokenname = $tokenname;
    }

    /**
     * Este metodo devuelve el toke de usuario si la sesion esta activa
     *
     *
     * @api
     */

    public static  function getToken() {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return $_SESSION[$this->tokenname];
        }
    }

    /**
     * Este metodo almacena el token de usuario en el deposito de sesion
     *
     * @param string $token El valor a almacenar
     *
     * @api
     */

    public static function setToken($token) {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return $_SESSION[$this->tokenname] = $token;
        }
    }

    /**
     * Este metodo devuelve el toke de usuario si la sesion esta activa
     *
     * @param string $token El token a validar
     *
     * @return bool Si el token es valido o no
     *
     * @api
     */

    public static function validateToken($token) {

        // Sin implementacion de momento

        return true;
    }
}

?>
