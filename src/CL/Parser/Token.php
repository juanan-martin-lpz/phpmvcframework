<?php

namespace GestionComercial\CL\Parser;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

abstract class Token {

    abstract function get(): string;

    function __toString()
    {
        return get_class($this);
    }
}

?>
