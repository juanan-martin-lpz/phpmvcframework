<?php

//require_once 'IRouter.php';

namespace MVCLite\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use MVCLite\Internal\SessionStorage;
use MVCLite\Internal\Credential;
use MVCLite\Internal\Storage;

/**
 * Implementacion estandar para el Router de la aplicacion
 *
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class SecuredRouter extends DefaultRouter {

    private IController $loginContoller;
    private string $token;

    /**
     * Constructor de la clase
     *
     * @param IController $loginCtrl Controlador del login
     *
     */

    public function __construct($loginCtrl) {

        parent::__construct();

        $this->loginController = $loginCtrl;
        $this->add('/login', $this->loginController);

    }

    /**
     * Metodo para invocar el controlador necesario para la ruta pasada en la $request. Si existe
     * un token de usuario se realiza la invocacion normalmente. Si no existe un token de usuario
     * se redirecciona a un controlador de Login para efectuara las tareas de acreditacion de usuario
     * Una vez que exista un token valido, se procede con el trafico normal.
     *
     *
     * @param Array $request La request pasada por el Dispatcher
     *
     * @api
     *
     * @todo Enlazar con el mecanismo de 404
     */

    public function route($request) {

        // Obtener el token

        $this->token = Credential::getToken();

        // Validar el token

        if (!Credential::validateToken($this->token)) {
            // Si el token no es valido redirigir a login y almacenar la request en el Storage
            // El storage se elimina en el controlador de login una vez aceptadas las credenciales de usuario
            Storage::setValue('pendingUrl', $request['url']);
            $request['url'] = '/login';
        }


        parent::route($request);



    }
}
?>
