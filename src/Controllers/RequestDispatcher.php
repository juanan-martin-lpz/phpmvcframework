<?php

//require_once 'IRouter.php';

namespace MVCLite\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

/**
 * Despacha las peticiones recibidas por la aplicacion al router
 *
 * Soporta multiples routers y antes de despachar la peticion solicita a los routers las urls que manejan.
 * Si alguna esta duplicada, sale con error.
 * Si no, las inserta en un arraya en cada peticion para saber a que router debe enviar la peticion.
 * Ademas crea un pequeño objeto/array con los datos de la peticion segun se recogen en la super $_SERVER
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class RequestDispatcher {

    private array $routers = [];     // Array de routers
    private array $routes = [];      // Array de rutas

    //private IRouter $router;  // Router

    /**
     * Constructor de la clase
     *
     * Construye la clase y almacena el router para su uso posterior
     *
     * @param IRouter $router El Router que se va a usar
     *
     * @api
     */

    public function __construct() {

        //$this->routers[] = $router;
        //$this->router = $router;
    }

    /**
     * Metodo para añadir mas routers al RequestDispatcher
     *
     * Este metodo añade un router adicional a la coleccion de routers
     *
     * @param IRouter $router El Router a añadir
     *
     * @api
     */
    public function addRouter(IRouter $router) {

        $this->routers[] = $router;

    }

    /**
     * Metodo que despacha la peticion al router seleccionado
     *
     * Primero se obtienen las rutas de todos los routers registrados en el dispatcher, creando un array asociativo con los datos
     * y segun la url solicitada se envia al router correspondiente.
     * Ademas crea un array asociativo donde almacena el metodo usado en la peticion, la url de destino que se usara
     * en el router para invocar al controlador oportuno y la posible cadena pasada como parte de la url
     * como parametro
     *
     * @api
     */

    public function dispatch() {

        $this->setupRoutes();


        // A ver aqui que hacemos con $_SERVER
        $request['method'] = $_SERVER['REQUEST_METHOD'];
        $request['url'] = $_SERVER['REQUEST_URI'] ?? "/";
        $request['query'] = $_SERVER['QUERY_STRING'] ?? "";

        return $this->_dispatch($request);
    }

    private function _dispatch($request) {


        $r = $this->routes[$request['url']];

        //
        $response = $r->route($request);

        // Examinamos el tipo de respuesta. Si es del tipo RedirectResponse redireccionamos y no devolvemos la salida estandar
        if (get_class($response) == 'MVCLite\Controllers\RedirectResponse') {
            // contentResponse tiene un objeto request. Hacemos la redireccion hacia dicha request
            $req = $response->contentResponse();

            header('Location: ' . $req['url']);
        }
        else {
            return $response->contentResponse();
        }
    }

    private function setupRoutes() {

        foreach($this->routers as $router) {
            $rutas = $router->getRoutes();

            foreach($rutas as $ruta) {
                if (!array_key_exists($ruta, $this->routes)) {
                    $this->routes[$ruta] = $router;
                }
            }
        }
    }
}
?>
