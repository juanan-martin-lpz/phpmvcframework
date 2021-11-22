<?php

namespace GestionComercial\Views;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use GestionComercial\Views\IRenderizable as IRenderizable;
use GestionComercial\CL\Parser\ComponentRegistry as Registry;

abstract class ComponentBase implements IRenderizable {

    protected $html;
    protected $data;
    protected $dom;

    // Solo queremos que las construyan instancias derivadas
    protected function __construct($data) {

        $this->data = $data;

    }

    protected function intepretDOM() {


        if ($this->html == "") {
            return;
        }

        $domx = new \DOMDocument();


        @$domx->loadHTML($this->html);

        $this->dom = $domx;

        $this->interpretNode($domx, []);

        return $domx;
    }

    private function interpretNode(&$node, $dict = []) {

        // Hacemos que los datos pasado al componente este disponibles en el diccionario

        //print_r($dict);

        if ($this->data != null){
            if ($dict != null) {
                if (is_array($this->data)) {
                    $dict = array_merge($this->data, $dict);
                }
                else {
                    $dict['data'] = $this->data;
                }
            }
            else {
                $dict['data'] = $this->data;
            }

        }

        $this->checkComponent($node, $dict);

        $this->expandAttributes($node, $dict);

        $this->expandVariables($node, $dict);


        if (($node != null) && ($node->hasChildNodes())) {

            $children = $node->childNodes;

            for ($i=0; $i < $children->count(); $i++ ) {
                $descendant = $children->item($i);
                $this->interpretNode($descendant, $dict);
            }
        }
    }

    private function checkComponent(&$n, &$dict) {

        //print_r($n);
        //echo "<br>";

        $componentReg = "/\w-\w/";

        if (@preg_match($componentReg, $n->tagName)) {

            $compName = $n->tagName;

            // Procesamos el componente
            // 1. Instanciamos
            // 2. loadHTML
            // 3. Reemplazar el componente por el DOM devuelto

            if (Registry::get($n->tagName)) {

                $klass = Registry::get($n->tagName);

                //echo "$compName\n";
                //print_r($this->data);
                //echo "<br>";

                $component = new $klass($dict);

                $newdom = $component->loadHTML();

                $arrayBody = $newdom->getElementsByTagName('body');

                // Si el body no tiene elementos, retornamos
                if ($arrayBody->length == 0) {
                    return;
                }

                $body = $arrayBody->item(0);

                // Si el body tiene un elemento y ese elemento es un div lo añadimos normalmente
                if ($body->childNodes[0]->tagName == 'div') {

                    $element = $body->childNodes->item(0)->cloneNode(true);


                    $parent = $n->parentNode;

                    $newnode = $this->dom->importNode($element, true);

                    $parent->replaceChild($newnode, $n);

                    //}
                /*                else {  // Creamos un div y lo añadimos
                    $div = $this->dom->createElement('div');
                    for ($j = 0; $j < $body->childElementCount; $j++ ) {
                        $item = $body->childNodes->item($j)->cloneNode(true);
                        $newnode = $this->dom->importNode($item, true);
                        $div->appendChild($newnode);
                    }
                    $parent = $n->parentNode;

                    $parent->replaceChild($div, $n);

                    }*/
                }
                else {    // Si tiene mas de un elemento los integramos en u div

                    $div = $this->dom->createElement('div');

                    for ($j = 0; $j < $body->childElementCount; $j++ ) {
                        $item = $body->childNodes->item($j)->cloneNode(true);

                        $newnode = $this->dom->importNode($item, true);
                        $div->appendChild($newnode);
                    }

                    $parent = $n->parentNode;
                    $parent->removeChild($n);
                    $parent->appendChild($div);
                }

                //$parent = $n->parentNode;
                //$parent->removeChild($n);

                //$this->dom->importNode($newdom);

                //$parent->appendChild($newdom);
            }
        }
    }

    private function getComponentFragment($nodo) {


    }

    private function expandVariables(&$n, &$dict) {

        $klass = "";

        try {
            if ($n != null) {
                $klass = get_class($n);
            }
            else {
                $klass = "string";
            }
        }
        catch (Exception $ex) {
            $klass = "string";
        }

        //print_r($dict);
        //echo "<br>";

        if ($klass == "DOMText") {
            // Expandimos variable entre llaves
            $regExpandVar = "/\{{2}.*\}{2}/";

            //var_dump($n);
            //echo "<br>";

            // OK
            if (@preg_match($regExpandVar, $n->textContent)) {

                $varname = trim(trim($n->textContent, "{"), "}");

                $var = explode('.', $varname);

                // Sustituir textContent por el valor de $dict[$varname]
                if (count($var) > 1) {
                    @$obj = $dict[$var[0]];
                    $prop = $var[1];

                    @$newNode = $this->dom->createTextNode($obj->$prop);
                    $parent = $n->parentNode;
                    $parent->replaceChild($newNode, $n);
                }
                else {
                    @$newNode = $this->dom->createTextNode($dict[$varname]);
                    $parent = $n->parentNode;
                    $parent->replaceChild($newNode, $n);
                }
            }
        }

    }

    private function expandAttributes(&$n, &$dict) {

        //print_r($n);
        //echo "<br>";

        if (($n != null) && ($n->hasAttributes())) {

            $attr = $n->attributes;

            // Iteramos por los atributos
            // El atributo puede ser un atributo normal o uno de los nuestros por lo que comprobaremos a traves de una expresion regular.
            foreach($attr as $a) {

                // Comprobar por expresion regular:
                // Variable
                // Si es variable tendra el formato data-<string>.
                // Si el valor del atributo, que deber ser una string, no esta en diccionario o e $data se toma como valor
                $regVar = "/data-/";

                if (@preg_match($regVar, $a->nodeName)) {

                    $varname = explode('-', $a->nodeName)[1];

                    $regExpandVar = "/\{{2}.*\}{2}/";

                    //var_dump($n);
                    //echo "<br>";
                    // OK
                    if (@preg_match($regExpandVar, $a->nodeValue)) {

                        $m = [];

                        @preg_match($regExpandVar, $a->nodeValue, $m);


                        $varname2 = trim(trim($m[0], "{"), "}");

                        $var2 = explode('.', $varname2);

                        // Sustituir textContent por el valor de $dict[$varname]
                        if (count($var2) > 1) {

                            @$obj = $dict[$var2[0]];
                            $prop = $var2[1];

                            $v = "";

                            if (method_exists($obj, $prop)) {
                                $v = $obj->{$prop}();
                            }
                            else {
                                $v = $obj->$prop;
                            }


                            $dict[$varname] = $v;

                        }
                        else {
                                @$dict[$varname] = $dict[$var2[0]];
                        }
                    }
                    else {
                        $dict[$varname] = $a->nodeValue;
                    }

                }

                $regExpandVarOpt = "/\[{2}.*\]{2}/";

                //var_dump($n);
                //echo "<br>";

                // OK
                if (@preg_match($regExpandVarOpt, $a->nodeValue)) {

                    $m = [];

                    @preg_match($regExpandVarOpt, $a->nodeValue, $m);


                    $varname = trim(trim($m[0], "["), "]");

                    $var = explode('.', $varname);

                    // Sustituir textContent por el valor de $dict[$varname]
                    if (count($var) > 1) {

                        @$obj = $dict[$var[0]];
                        $prop = $var[1];

                        if ($obj == null) {
                            $n->removeAttribute($a->nodeName);
                            $n->setAttribute($a->nodeName, "");
                        }
                        else {
                            $v = "";

                            if (method_exists($obj, $prop)) {
                                $v = $obj->{$prop}();
                            }
                            else {
                                $v = $obj->$prop;
                            }

                            $val = @preg_replace($regExpandVarOpt, $v, $a->nodeValue);

                            $n->removeAttribute($a->nodeName);
                            $n->setAttribute($a->nodeName, $val);
                        }


                    }
                    else {
                        if (is_set($dict[$var[0]])) {
                            $val = @preg_replace($regExpandVar, $dict[$var[0]], $a->nodeValue);

                            $n->removeAttribute($a->nodeName);
                            $n->setAttribute($a->nodeName, $val);
                        }
                        else {
                            $n->removeAttribute($a->nodeName);
                            $n->setAttribute($a->nodeName, "");
                        }
                    }
                }


                //print_r($a);
                //echo "<br>";
                $regExpandVar = "/\{{2}.*\}{2}/";

                //var_dump($n);
                //echo "<br>";

                // OK
                if (@preg_match($regExpandVar, $a->nodeValue)) {

                    $m = [];

                    @preg_match($regExpandVar, $a->nodeValue, $m);


                    $varname = trim(trim($m[0], "{"), "}");

                    $var = explode('.', $varname);

                    // Sustituir textContent por el valor de $dict[$varname]
                    if (count($var) > 1) {

                        @$obj = $dict[$var[0]];
                        $prop = $var[1];

                        $val = @preg_replace($regExpandVar, $obj->$prop, $a->nodeValue);

                        $n->removeAttribute($a->nodeName);
                        $n->setAttribute($a->nodeName, $val);


                    }
                    else {
                        //                        print_r($dict);

                        $val = @preg_replace($regExpandVar, $dict[$var[0]], $a->nodeValue);

                        $n->removeAttribute($a->nodeName);
                        $n->setAttribute($a->nodeName, $val);
                    }
                }


                //continue;

                // *dsIf
                // El patron es [*dsIf]="expresion" donde expresion evaluara a boolean
                // Si es false se eliminan los nodos hijos
                $regIf = "/ds[Ii]f/";


                if (@preg_match($regIf, $a->nodeName)) {

                    $expr = $a->nodeValue;

                    //print_r($expr);
                    //echo "<br>";

                    $value = $dict[$expr];

                    if (!$value) {
                        // Si evalue a false nos cargamos el nodo y sus descendientes
                        $parent = $n->parentNode;

                        $parent->removeChild($n);
                    }
                }

                // dsFor
                // El patron a buscar es dsFor. El valor sera en formato "coleccion as/AS variable". En un futuro se podria poner ademas un ";index=val" para poder tener un indice con base el valor que den
                // Donde coleccion debe existir en $data y variable sera usada en los hijos
                // Iteramos coleccion en $data e interpretamos nodo para cada uno de ellos. Variable debe ir al diccionario
                $regFor = "/ds[Ff]or/";

                //OK
                if (@preg_match($regFor, $a->nodeName)) {

                    [$coleccion, $as, $variable] = explode(" ", $a->nodeValue);

                    // 1. Copiamos los hijos a un lugar seguro
                    // 2. Montamos un foreach con la coleccion que estara en $dict[$coleccion] con variable $variable
                    // 3. Procesamos cada hijo con interpretNode que nos modificara cada instancia in-place dentro del foreach

                    $node = $n->cloneNode();

                    if (isset($dict[$coleccion])) {

                        //$newdict = array_merge($dict, []);

                        //$col = $newdict[$coleccion];
                        $col = $dict[$coleccion];

                        if(is_array($col)) {

                            // Por cada elemento de la coleccion creamos un hijo al nodo
                            foreach($col as $value) {

                                // Actualizamos el diccionario
                                //$newdict[$variable] = $value;

                                // Por cada hijo original, clonamos y añadimos
                                foreach($n->childNodes as $cnode) {
                                    $nuevo = $cnode->cloneNode(true);
                                    //$this->interpretNode($nuevo, $newdict);
                                    $dict[$variable] = $value;

                                    $this->interpretNode($nuevo, $dict);
                                    $node->appendChild($nuevo);
                                }

                            }
                        }

                        $parent = $n->parentNode;
                        $parent->replaceChild($node, $n);

                    }
                    //continue;
                }

            }
        }

    }

    abstract public function loadHTML();
    abstract public function render(): string;
}
?>
