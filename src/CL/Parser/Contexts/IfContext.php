<?php

namespace GestionComercial\CL\Parser\Contexts;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class IfContext implements IContext {

    private $leftContext;
    private $rightContext;

    private $left;
    private $right;
    private $op;

    public function __construct($data) {

        $this->data = $data;
        $this->left = null;
        $this->right = null;
        $this->op = null;

        $this->leftContext = [];
        $this->rightContext = [];

    }

    private function isVar($token) {
        return !isString($token);
    }

    private function isString($token) {
        if ((str_starts_with($token, "\"") or str_starts_with($token, "\'")) and (str_starts_with($token, "\"") or str_starts_with($token, "\'"))) {
            return true;
        }
        else {
            return false;
        }
    }

    private function evalIfBool() {

        $result = "";
        // Caso 1. if var
        if (isset($this->data[$this->left])) {
            if ($this->data[$this->left]) {
                foreach($this->leftContext as $context) {
                    $result .= $context->getHtml();
                }
            }
            else {
                if ($this->rightContext != null) {
                    foreach($this->rightContext as $context) {
                        $result .= $context->getHtml();
                    }
                }
            }
        }
        else {
            $result = "Error de Sintaxis: Variable no existe";
        }
    }

    private function evalBothSides() {

        $result = "";
        $left = "";
        $right = "";

        // Caso 2. Var op Var // Var op Val // Val op Var...
        if (isVar($this->left)) {
            if (isset($this->data[$this->left])) {
                $left = $this->data[$this->left];
            }
            else {
                return "Error de Sintaxis: Se esperaba una variable";
            }
        }
        else {
            $left = $this->left;
        }

        if (isVar($this->right)) {
            if (isset($this->data[$this->right])) {
                $right = $this->data[$this->right];
            }
            else {
                return "Error de Sintaxis: Se esperaba una variable";
            }
        }
        else {
            $right = $this->right;
        }



        if (eval("$left $this->op $right")) {
            foreach($this->leftContext as $context) {
                $result .= $context->getHtml();
            }
        }
        else {
            if ($this->rightContext != null) {
                foreach($this->rightContext as $context) {
                    $result .= $context->getHtml();
                }
            }
        }

        return $result;
    }


    public function addLeft(IContext $context) {
        $this->leftContext->push($context);
    }

    public function addRight(IContext $context) {
        $this->rightContext->push($context);
    }

    public function addOp($op) {
        switch ($op) {
        case ('EQ'):
            $this->op = '=';
            break;
        case ('GREATER_EQ'):
            $this->op = '>=';
            break;
        case ('LESS_EQ'):
            $this->op = '<=';
            break;
        case ('GREATER'):
            $this->op = '>';
            break;
        case ('LESS'):
            $this->op = '<';
            break;

        }
    }

    public function addLeftOp($op) {
        $this->left = $op;
    }

    public function addRightOp($op) {
        $this->right = $op;
    }

    public function getHtml(): string {
        $result = "";

        // Caso 1
        if ($this->op == null and $this->right == null) {
            if (isVar($this->left)) {
                $result = $this->evalIfBool();
            }
            else {
                $result = "Error de Sintaxis: Se esperaba una variable";
            }
        }

        return $result;
    }
}
?>
