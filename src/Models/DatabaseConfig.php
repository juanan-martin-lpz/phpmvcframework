<?php

namespace MVCLite\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

/**
 * Clase que almacena la configuracion para la conexion a una base de datos
 *
 * Obtiene los valores necesarios de un fichero json o bien por asignacion manual
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 */

class DatabaseConfig {

    /**
     * Metodo estatico para obtener los datos de configuracion de un fichero json
     *
     * @param string $filename El fichero a leer
     *
     * @return DatabaseConfig La configuracion de la conexion
     * @api
     */

    public static function fromJSON(string $filename) {

        $data = file_get_contents($filename);

        $obj = json_decode($data);

        $cfg = new DatabaseConfig();

        $cfg->driver = $obj->driver;
        $cfg->host = $obj->host;
        $cfg->port = $obj->port;
        $cfg->databasename = $obj->databasename;
        $cfg->user = $obj->user;
        $cfg->password = $obj->password;

        return $cfg;
    }

    public string $driver;
    public string $host;
    public int $port;
    public string $databasename;
    public string $user;
    public string $password;
}


?>
