<?php

namespace MVCLite\Views;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

interface IRenderizable {
    public function render(): string;
}
?>
