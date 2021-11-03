<?php

namespace GestionComercial\Controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

interface IAction {
    public function execute($data = null): string;
}

?>
