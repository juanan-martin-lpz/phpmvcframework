<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/*
$input = file_get_contents('test.html');


$data['user'] = "Usuario nuevo";

$parser = new GestionComercial\CL\Parser\Parser($input, $data);

//print_r($parser->tokenizer());

$parser->parse();

//print_r($parser->parse());
*/


use GestionComercial\Views\ComponentBase as Base;
use GestionComercial\CL\Parser\ComponentRegistry as Registry;


Registry::add('otro-componente','\Componente');
Registry::add('otro-comp','\Componente2');

class testView extends Base {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function loadHTML() {

        $this->html = file_get_contents("test.html");

        //$dom =
        $this->dom = $this->intepretDOM();

        return $this->dom;
    }

    public function render(): string {

        $this->html = $this->dom->saveHTML($this->dom);

        echo $this->html;
        return $this->html;
    }
}

class Componente extends Base {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function loadHTML() {

        $this->html = "<p>{{variable}}</p>";

        $this->dom = $this->intepretDOM();

        return $this->dom;
    }

    public function render(): string {

        if (is_bool($n)) {
            return "";
        }

        $this->html = $this->dom->saveHTML($this->dom);

        echo $this->html;
        return $this->html;
    }
}


class Componente2 extends Base {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function loadHTML() {

        $this->html = "<p>{{sample.a}}</p><p>Texto</p>";

        $this->dom = $this->intepretDOM();

        return $this->dom;
    }

    public function render(): string {

        if (is_bool($n)) {
            return "";
        }

        $this->html = $this->dom->saveHTML($this->dom);

        echo $this->html;
        return $this->html;
    }
}

class Sample {
    public $a;
    public $b;
}

$sample = new Sample();
$sample->a = "Sample A";
$sample->b = "Sample B";

$coleccion['saludo'] = "Hola";
$coleccion['despedida'] = "Adios";

$data['sample'] = $sample;
$data['variable'] = "Hola Mundo";
$data['coleccion'] = $coleccion;

$tv = new TestView($data);

$tv->loadHTML();

$tv->render();


?>
