<?php

//require_once 'IController.php';

namespace GestionComercial\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


class ControllerBase implements IController {

    protected string $router;
    protected $actions;

    public function __construct() {

    }

    protected function addAction(string $key, $action) {

        if ($key == '') {
            $key = '__default__';
        }

        if ($action == null) {
            // Error
        }

        $this->actions[$key] = $action;
    }

    protected function getAction($key) {

        if ($key == '') {
            $key = '__default__';
        }

        return $this->actions[$key];
    }

    protected function executeAction($key, $data): string {

        if (($key == '') || ($key == null)) {
            $key = '__default__';
        }

        $action = $this->getAction($key);

        if ($action != null) {
            return $action->execute($data);
        }
        else {
            // Deberia ser un 404 puesto que la accion no existe
            return "";
        }
    }

    public function doGet($request): string
    {

        // Dependiendo de los parametros tendriamos que cargar una vista u otra
        // Si vienen en la url podria ser tipo edit/id o detail/id
        // Pero tambien podrian venir via query string edit=true;id=1
        // Esto no es personalizable aunque puede ser estandarizado de una forma u otra


        $action = null;

        $data = null;

        if (isset($request['params']) && $request['params']) {
            // No controlamos el count
            $action = $request['params'][0];
            $data = $request['params'][1];
        }


        /*
        if ($request['query']) {

            $items = explode(';', $request['query']);

            foreach($items as $item) {
                $ite = explode('=',$item);
                $action = $ite[1];
            }
        }
        */

        return $this->executeAction($action, $data);

        //return "Hola desde el controlador. Me pides que haga $action contra el id $data";
    }

    public function doPost($request): string
    {

    }

}
?>
