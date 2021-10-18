<?php

//require_once 'IController.php';

namespace GestionComercial\Controllers;

require '../vendor/autoload.php';


class PedidosController implements IController {

    public function doGet($request)
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


        if ($request['query']) {

            $items = explode(';', $request['query']);

            foreach($items as $item) {
                $ite = explode('=',$item);
                $action = $ite[1];
            }
        }

        return "Hola desde el controlador. Me pides que haga $action contra el id $data";
    }

    public function doPost($request)
    {

    }
}
?>
