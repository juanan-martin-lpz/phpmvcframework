<?php

//require_once 'IController.php';

namespace MVCLite\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Clase base con el comportamiento por defecto de los Controladores
 *
 *
 * El comportamiento por defecto se basa en Acciones.
 * Una accion es un fragmento de codigo que se ejecutara llegado el momento a traves de la interfaz IAction.
 * Las acciones nos permiten segmentar la responsabilidad de control en dos partes, una de control y otra mas ejecutiva
 * dejando a la accion el control sobre la vista, lo que nos permite tener multiples vistas para el mismo controlador
 * Los valores devueltos por la accion son interceptados o susceptibles de ser interceptados nuevamente por el controlador
 * para que efectue su tarea de control.
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class ControllerBase implements IController {

    protected string $router;
    protected $actions;

    public function __construct() {

    }

    /**
     * Añade una accion al array asociativo de acciones
     *
     *
     * @param string $key Nombre de la accion
     * @param IAction $action La accion a usar
     *
     * @api
     */

    protected function addAction(string $key, $action) {

        if ($key == '') {
            $key = '__default__';
        }

        if ($action == null) {
            // Error
        }

        $this->actions[$key] = $action;
    }

     /**
     * Obtiene una accion por su clave
     *
     *
     * @param string $key La clave que identifica a la accion
     *
     * @return IAction La accion devuelta
     *
     * @api
     */

    protected function getAction($key) {

        if ($key == '') {
            $key = '__default__';
        }

        return $this->actions[$key];
    }

    /**
     * Ejecuta una accion por su clave
     *
     * Metodo por defecto para ejecucion de Acciones
     * La accion por defecto del controlador sera llamada __default__ y sera añadida sin clave, solo con el valor.
     * El resto de acciones sera identificada por su clave
     * Se recomienda que las acciones tengan el nombre que se quiera usar en la url para ellas, teniendo en cuenta que la mayoria
     * de las veces estaran en una ruta parcial que recibira como parametro dicho nombre de accion, siendo esta la implementacion por defecto.
     * Un ejemplo seria, si la ruta es /pedidos, la accion podria llamarse edit con lo que una peticion a /pedidos/edit/1 se traduciria
     * en una llamada al controlador de pedidos, con la accion edit (previamente registrada) que recibiria como parametro el valor 1
     * que bien podria ser el numero de pedido a editar
     * La implementacion por defecto solo reconocera dos elementos adicionales en la url aparte de la ruta completa. El primero sera
     * la accion y el segundo sera un valor arbitrario con significado para la accion concreta.
     *
     * @param string $key La clave que identifica a la accion
     *
     * @return string El resultado de la Accion. Generalmente html
     *
     * @api
     */

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

    /**
     * Implementacion por defecto para una peticion GET
     *
     *
     * @param Array $request Los datos de la peticion llegados del Router
     *
     * @return string La respuesta a la peticion GET. Generalmente sera html
     *
     * @api
     */

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
            @$data = $request['params'][1];
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

    /**
     * Implementacion por defecto para una peticion POST
     *
     * La implementacion por defecto para el POST esta vacia
     *
     * @param Array $request Los datos de la peticion llegados del Router
     *
     * @return string La respuesta a la peticion POSt. Generalmente sera html
     *
     * @api
     */

    public function doPost($request): string
    {

    }

}
?>
