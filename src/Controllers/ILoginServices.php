<?php


namespace MVCLite\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Interfaz para la gestion del Login
 *
 * Esta interfaz se encarga de, segun el verbo pasado en la request de la ruta
 * de gestionar la respuesta, segun sea GET o POST
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category interface
 *
 */
interface ILoginServices {

    /**
     * Funcion para realizar el login
     *
     *
     * @param object $user Objeto representando el usuario a loguearse
     *
     * @return object Objeto con las credenciales necesarias o null en caso de login fallido
     *
     * @api
     */

    public function login($user);

    /**
     * Funcion para validar credenciales
     *
     *
     * @param object $credential Objeto representando las credenciales
     *
     * @return boolean True si las credenciales son validas, false en caso contrario
     *
     * @api
     */

    public function validate($credential);

    /**
     * Funcion para desloguear (sic) a un usuario
     *
     *
     * @param object $credential Objeto representando las credenciales
     *
     * @return boolean True si se deslogueo con exito, false en caso contrario
     *
     * @api
     */

    public function logout($credential);


}
?>
