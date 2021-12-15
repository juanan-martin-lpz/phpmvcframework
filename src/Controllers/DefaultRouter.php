<?php

namespace MVCLite\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Implementacion estandar para el Router de la aplicacion
 *
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class DefaultRouter implements IRouter {

    private array $routes;  // Array de rutas

    /**
     * Constructor de la clase
     */

    public function __construct() {

        $this->routes = [];
    }

    /**
     * Añade la ruta al array asociativo de rutas con el controlador como valor
     *
     *
     * @param string $route La ruta a añadir
     * @param IController $controllet El controlador a usar en dicha ruta
     *
     * @api
     */

    public function add(string $route, IController $controller) {

        $this->routes[$route] = $controller;

    }

    /**
     * Retornamos un array con las rutas manejadas
     *
     *
     * @api
     */

    public function getRoutes() {

        return array_keys($this->routes);
    }

    /**
     * Metodo para invocar el controlador necesario para la ruta pasada en la $request
     *
     * Analiza la ruta pasada en $request e invoca al controlador necesario
     * La ruta puede ser de dos tipos: parcial o completa
     * Una ruta completa es la que se encuentra directamente dentro del array de rutas
     * Una ruta parcial es la que no se encuentra directamente dentro del array de rutas pero es susceptible
     * de que alguna de las rutas existentes coincidan con parte del comienzo de la ruta solicitada
     * En ese caso, se invocara el Controlador de la ruta coincidente pasandole el resto de la ruta como parametros
     * en un array
     * Si no se encuentra la ruta se devuelve un 404.
     *
     * @param Array $request La request pasada por el Dispatcher
     *
     * @api
     *
     * @todo Enlazar con el mecanismo de 404
     */

    public function route($request) {

        // Estrategia:
        // Si la ruta existe completa -> ejecutar el controlador
        // Si no existe completa buscar una clave que comience con la ruta
        // y si la hay llamar a dicho controlador.
        // La ruta que se incluira en la request sera de / para el match
        // y el resto de la ruta para el parcial

        $controller = null;

        // Si existe una ruta completa....
        $controller = @$this->routes[$request['url']];

        // Ruta parcial
        if (!$controller) {

            // Recorremos las rutas y miramos a ver si hay alguna que nos sirva
            foreach($this->routes as $route => $control) {

                if (str_starts_with($request['url'], $route)) {
                    // Match, habemus controlador
                    $controller = $control;
                    // La ruta esta al inicio, el resto es parametros
                    // Los separamos con split
                    $base = explode('/', $route);
                    $requested = explode('/',$request['url']);

                    $paramarray = [];

                    for($i = count($base); $i <= count($requested) -1; $i++) {
                        $paramarray[] = $requested[$i];
                    }

                    $request['params'] =  $paramarray; //substr($request['url'], strlen($route));
                }
            }

            // Si no ha encontrado nada, 404
            if (!$controller) {
                return "404";
            }
        }

        // Si llegados aqui no hay controller enviamos 404
        if (!$controller) {
            return  "404";
        }

        // Segun el metodo, llamamos al metodo controlador oportuno
        switch (strtoupper($request['method'])) {
        case 'GET':
            return $controller->doGet($request);
        case 'POST':
            return $controller->doPost($request);
        }
    }
}
?>
