<?php

namespace MVCLite\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

/**
 * Interfaz para el control de las rutas
 *
 * Esta interfaz expone el comportamiento basico de las rutas de la aplicacion
 * Dipone de dos metodos, add y route
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category interface
 *
 */

interface IRouter {

    /**
     * Funcion para añadir una ruta a un contenedor de rutas
     *
     * La clase implementadora debe encargarse del contenedor de rutas, que sera normalmente un array asociativo
     * con clave $route y valor $controler
     *
     * @param string $route Ruta a la que respondera el controlador
     * @param IController Controlador que se encargara de manejar la ruta
     */

    public function add(string $route, IController $controller);

    /**
     * Funcion derivar el control de ejecucion a la ruta necesaria
     *
     * La clase implementadora debe encargarse de comprobar la ruta pasada en $request y derivarla segun convenga
     * al controlador oportuno
     *
     * @param object $request Objeto del tipo request
     */

    public function route($request);

    /**
     * Funcion para retornar las rutas que maneja el router
     *
     *
     */

    public function getRoutes();


}
?>
