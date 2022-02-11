<?php

namespace MVCLite\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

/**
 * Interfaz para el control de las respuestas desde los controladores al dispatcher
 *
 * Esta interfaz expone el comportamiento basico de una respuesta hacia el dispatcher
 * para que este tome las medidas oportunas segun el tipo de la respuesta
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category interface
 *
 */

interface IDispatcherResponse {

    /**
     * Retorna el contenido de la respuesta
     *
     * La clase implementadora debe encargarse de mantener el tipo adecuado
     *
     * @api
     */
    public function contentResponse();

    /**
     * Retorna el tipo de la respuesta
     *
     * @api
     */
    public function typeResponse();

}
?>
