<?php

require_once 'IRouter.php';

class DefaultRouter implements IRouter {

    private array $routes;

    public function __construct() {
        $this->routes = [];
    }

    public function add(string $route, IController $controller) {
        $this->routes[$route] = $controller;
    }

    public function route($request) {

        // Estrategia:
        // Si la ruta existe completa -> ejecutar el controlador
        // Si no existe completa buscar una clave que comience con la ruta
        // y si la hay llamar a dicho controlador.
        // La ruta que se incluira en la request sera de / para el match
        // y el resto de la ruta para el parcial

        $controller = null;

        $controller = @$this->routes[$request['url']];

        var_dump($this->routes);

        // Ruta parcial
        if (!$controller) {
            // Parcial
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
