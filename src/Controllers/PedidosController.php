<?php

require_once 'IController.php';

class PedidosController implements IController {

    public function doGet($request)
    {
        var_dump($request);

        return "Hola desde el controlador";
    }

    public function doPost($request)
    {

    }
}
?>
