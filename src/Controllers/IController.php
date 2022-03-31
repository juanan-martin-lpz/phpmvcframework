<?php


namespace MVCLite\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Interfaz para el control de los Controladores
 *
 * Esta interfaz se encarga de, segun el verbo pasado en la request de la ruta
 * de gestionar la respuesta, segun sea GET o POST
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category interface
 *
 */
interface IController {

    /**
     * Funcion para atender las peticiones GET del controlador
     *
     *
     * @param object $request Request pasada al controlador
     */

    public function doGet($request);

    /**
     * Funcion para atender las peticiones POST del controlador
     *
     *
     * @param object $request Request pasada al controlador
     */

    public function doPost($request);
}
?>
