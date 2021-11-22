<?php

//require_once 'IController.php';

namespace GestionComercial\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Controllers\Actions\TiposIva as Actions;
use GestionComercial\Models as Models;
use GestionComercial\Models\Database as Database;

class TiposIvaController extends ControllerBase {

    private $data;

    public function __construct() {

        // Creamos las acciones. Algunas necesitaran del parser para poder pasarselo a las Vistas
        // Otras quizas no porque sean solo html

        $this->addAction('', new Actions\TiposIvaDefaultAction());
        $this->addAction('new', new Actions\TiposIvaNewAction());
        $this->addAction('edit', new Actions\TiposIvaEditAction());

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

            @$id = $request['params'][1];

            if ($id != null) {
                $sql = "SELECT * FROM TIPOS_IVA WHERE idtipo_iva = :id";

                $params[':id'] = [$id, \PDO::PARAM_INT];

                $result = Database::query($sql, $params);

                if (!empty($result)) {
                    $data = $result[0];
                }
            }
            else {
                @$data = intval($request['params'][1]);
            }

        }

        $request['params'][0] = $action;
        $request['params'][1] = $data;

        return parent::doGet($request);

    }

    public function doPost($request): string
    {
        $tipo = new Models\Tipos_Iva();

        if (isset($_POST['idtipo_iva'])) {
            $tipo->setIdTipoIva($_POST['idtipo_iva']);
        }

        $tipo->setDescripcion($_POST['descripcion_tipo_iva']);
        $tipo->setTipoIva(floatval($_POST['tipo_iva']));

        $this->data = $tipo;

        try {
            if ($tipo->save()) {

                $request['method'] = 'GET';
                $request['url'] = "/tiposiva";
                $request['query'] = "";

                return $this->doGet($request);
            }
        }
        catch (\PDOException $ex) {

            // Gestion de errores. Aun por confirmar el modo

            $req['method'] = 'GET';
            $req['url'] = "/tiposiva";

            if ($tipo->getIdTipoIva() == null || $tipo->getIdTipoIva() == 0) {
                $req['params'] = ["new", $tipo];
            }
            else {
                $req['params'] = ["edit", $tipo];
            }

            return $this->doGet($req);

            //return $ex->getMessage();
        }

    }
}
?>
