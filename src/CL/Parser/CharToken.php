<?php

namespace GestionComercial\CL\Parser;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class CharToken extends Token {
    private $char;

    public function __construct($char) {
        $this->char = $char;
    }

    public function get(): string {
        return $this->char;
    }
}

?>
