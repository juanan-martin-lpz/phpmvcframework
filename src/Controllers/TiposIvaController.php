<?php

//require_once 'IController.php';

namespace GestionComercial\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Controllers\Actions\TiposIva as Actions;

class TiposIvaController extends ControllerBase {

    public function __construct() {

        // Creamos las acciones. Algunas necesitaran del parser para poder pasarselo a las Vistas
        // Otras quizas no porque sean solo html

        $this->addAction('', new Actions\TiposIvaDefaultAction());

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

        if ($action == null) {

            return parent::doGet($request);
        }
        /*

        if ($request['query']) {

            $items = explode(';', $request['query']);

            foreach($items as $item) {
                $ite = explode('=',$item);
                $action = $ite[1];
            }
        }

        return "Hola desde el controlador. Me pides que haga $action contra el id $data";
        */

        // Llamar al doGet del padre si la accion sera ejecutar una IAction
    }

    public function doPost($request): string
    {

    }
}
?>
