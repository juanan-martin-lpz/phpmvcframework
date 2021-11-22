<?php

// Crear el Registro
//-------------------------------------------------------------------


/* Añadir todos los componentes de la aplicacion cual Angular caso se tratara */

/*

ComponentRegistry::add('login-component','LoginComponent');
ComponentRegistry::add('login-header-component','LoginHeaderComponent', 'LoginComponent');
ComponentRegistry::add('login-footer-component','LoginFooterComponent', 'LoginComponent');


*/


//-------------------------------------------------------------------


namespace GestionComercial;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\CL\Parser\ComponentRegistry as Registry;
use GestionComercial\Models\DatabaseConfig as Config;
use GestionComercial\Models\Database as DB;


// Registramos todos los componentes

// Header y Footer
Registry::add('app-header','\GestionComercial\Views\Componentes\AppHeader');
Registry::add('app-footer','\GestionComercial\Views\Componentes\AppFooter');

// Genericos
Registry::add('boton-nuevo','\GestionComercial\Views\Componentes\BotonNuevo');


// Tipos de IVA
Registry::add('grid-tiposiva','\GestionComercial\Views\Componentes\GridTiposIva');
Registry::add('botonera-tiposiva','\GestionComercial\Views\Componentes\BotoneraTiposIva');

?>
