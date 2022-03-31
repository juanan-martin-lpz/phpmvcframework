<?php

namespace MVCLite\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Interfaz para crear objetos personalizados de un determinado modelo
 *
 * El objetivo de esta interfaz es que las clases que lo implementen sean capaz de construir arrays de instancias de un modelo en concreto
 * en lugar de un objeto generico o un array asociativo que usara, los nombres de los campos de la base de datos y asi dar un mejor soporte
 * al patron MVC.
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

interface IConcreteModelFactory {

    /**
     * Crea un array de objetos del modelo a partir de un array asociativo
     *
     * @param Array $data El array asociativo
     *
     * @return Array Retorna un array de objetos
     *
     * @api
     */

    static function fromAssoc($data);

    /**
     * Crea un un objeto tipado de la clase a la que este dato soporte la Factoria
     *
     *
     * @return Array Un objeto tipado
     *
     * @api
     */

    static function create();
}



?>
