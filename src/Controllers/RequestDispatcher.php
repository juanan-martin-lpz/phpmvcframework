<?php

require_once 'IRouter.php';

class RequestDispatcher {
    private IRouter $router;

    public function __construct(IRouter $router) {
        $this->router = $router;
    }

    public function dispatch() {
        // A ver aqui que hacemos con $_REQUEST
        var_dump($_SERVER);
    }

}
?>
