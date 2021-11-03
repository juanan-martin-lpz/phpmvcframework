<?php

namespace GestionComercial\Models;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class DatabaseConfig {


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
