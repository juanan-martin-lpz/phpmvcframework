<?php

namespace GestionComercial\Models;

require '../vendor/autoload.php';

interface IConcreteModelFactory {
    static function fromAssoc($data);
    static function create();
}



?>
