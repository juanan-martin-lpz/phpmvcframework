<?php

require_once 'IRouter.php';

class RequestDispatcher {

    private IRouter $router;

    public function __construct(IRouter $router) {
        $this->router = $router;
    }

    public function dispatch() {
        // A ver aqui que hacemos con $_SERVER
        $request['method'] = $_SERVER['REQUEST_METHOD'];
        $request['url'] = $_SERVER['REQUEST_URI'] ?? "/";
        $request['query'] = $_SERVER['QUERY_STRING'] ?? "";

        return $this->router->route($request);
    }

}
?>
