<?php

namespace GestionComercial\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Interfaz para el control de las Acciones
 *
 * Esta interfaz declara un metodo para ejecutar las acciones como respuesta a las
 * peticiones al Controlador
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category interface
 *
 */

interface IAction {
    /**
     * Funcion que implementa la accion a realizar, generalmente invocar una Vista
     *
     *
     * @param Array $data Recibe un array asociativo con lo datos a pasar a las vistas
     */

    public function execute($data = null): string;
}

?>
