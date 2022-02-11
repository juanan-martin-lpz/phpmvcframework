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
    private Credential $credentialAdmin;

    private string $token;

    /**
     * Constructor de la clase
     *
     * @param IController $loginCtrl Controlador del login
     *
     */

    public function __construct($loginCtrl, $credentialAdmin) {

        parent::__construct();

        $this->loginController = $loginCtrl;
        $this->credentialAdmin = $credentialAdmin;

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

        // Si es una ruta directa y el metodo es POST, es decir la url es /login tenemos dos opciones
        // o redirigimos a la ruta principal segura o redirigimos a la pagina principal
        // almacenando el token en el Storage

        if ($request['url'] == '/login' && $request['method'] == 'POST') {

            $req['method'] = 'GET';
            $req['url'] = "/";
            $req['query'] = "";

            return new RedirectResponse($req);
        }
        else {
            if ($request['url'] == '/login' && $request['method'] == 'GET') {
                return parent::route($request);
            }
            else {
                // Si no es ruta directa, procedemos de otra forma
                // Obtener el token
                $this->token = $this->credentialAdmin->getToken() ?? "";

                // Si se trata de entrar en una ruta segura y no hay token, redirigimos a login
                // Si el token es valido y tenemos una url pendiente
                if ($this->credentialAdmin->validateToken($this->token) && Storage::getValue('pendingUrl') != null) {
                    $request['url'] = Storage::getValue('pendingUrl');
                    Storage::deleteKey('pendingUrl');
                }
                else {
                    // Validar el token
                    if (!$this->credentialAdmin->validateToken($this->token)) {
                        // Si el token no es valido redirigir a login y almacenar la request en el Storage
                        // El storage se elimina en el controlador de login una vez aceptadas las credenciales de usuario
                        Storage::setValue('pendingUrl', $request['url']);
                        $request['url'] = '/login';
                    }
                }

                return new HtmlResponse($request);
            }
        }
    }
}
?>
