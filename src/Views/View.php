<?php

namespace MVCLite\Views;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class View implements IRenderizable {

    private $rawHtml;
    private $data;
    private $parser;

    public function __construct($data, $parser = null) {
        $this->data = $data;
        $this->parser = $parser;
    }

    protected function loadView($filename) {

        $this->rawHtml = file_get_contents($filename);
    }

    public function render(): string {

    }
}

?>
