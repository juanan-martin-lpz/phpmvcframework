<?php

namespace GestionComercial\CL\Parser\Contexts;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class ForContext implements IContext {

    private $contexts;
    private $count;
    private $data;

    public function __construct($data) {
        $this->count = 0;
        $this->data = $data;
        $this->contexts = [];
    }

    public function add(IContext $context) {
        $this->contexts->push($context);
    }

    public function setCount($count) {
        $this->count = $count;
    }

    public function getHtml(): string {
        $result = "";

        for($i = 0; i < $this->count; $i++) {
            foreach($this->contexts as $context) {
                $result .= $context->getHtml();
            }
        }

        return $result;
    }
}
?>
