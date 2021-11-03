<?php

namespace GestionComercial\CL\Parser;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


use GestionComercial\CL\Parser\Contexts\VarContext as VarC;
use GestionComercial\CL\Parser\Contexts\IfContext as IfC;
use GestionComercial\CL\Parser\Contexts\ForContext as ForC;
use GestionComercial\CL\Parser\Contexts\HtmlContext as HtmlC;
use GestionComercial\CL\Parser\Contexts\ComponentContext as CompC;

class Parser {


    private $registry;

    private $input;
    private $currentpos = 0;
    private $relativepos = 0;
    private $asArray = [];


    private const VAR_SYMBOL = 1; //'$';
    private const FOR_SYMBOL = 2; //'@';
    private const IF_SYMBOL = 3; //'?';
    private const CLOSE_FOR_SYMBOL = 4;
    private const CLOSE_IF_SYMBOL = 5;
    private const AS_SYMBOL = 6; //'>>';

    private const CHAR = 7; // ???

    private const OPEN_BRACKET = 8; //'[';
    private const CLOSE_BRACKET = 9; //']';
    private const OPEN_PARENS = 10; //'(';
    private const CLOSE_PARENS = 11; //')';

    private const COLON = 12; //':';
    private const SEMILCOLON = 13; //';';
    private const SEPARATOR_TOKEN = 14; //'|';

    private const EQUAL = 15; //'=';
    private const NOT_EQUAL = 16; //'!=';
    private const GREATER_THAN = 17; //'>';
    private const LESS_THAN = 18; //'<';
    private const GREATER_EQ_THAN = 19; //'>=';
    private const LESS_EQ_THAN = 20; //'<=';

    private const BLANK_SYMBOL = 21; //' ';
    private const TAB_SYMBOL = 22; //' ';
    private const NEWLINE_SYMBOL = 23; //' ';

    private const OPEN_ANGLE_BRACKETS = 24; // ???
    private const CLOSE_ANGLE_BRACKETS = 25; // ???
    private const SLASH = 26; // ???
    private const DOUBLE_QUOTE = 27; // ???
    private const SINGLE_QUOTE = 28; // ???

    private const VARIABLE = 100;
    private const VALUE = 101;


    private $data = null;

    public function __construct($input, $data, $registry = null) {
        $this->input = $input;
        $this->data = $data;

        $this->registry = $registry;
    }

    public function parse() {

        $tokens = $this->tokenizer();

        $AST = $this->parser($tokens);


        //var_dump($result);
        // return
        //return $result;

        //var_dump($AST);
        /*
        foreach($AST as $node) {

            //if (get_class($node) == 'CustomToken' || get_class($node) == 'SyntaxToken' || get_class($node) == 'CharToken' ) {
            if (is_object($node)) {
                echo get_class($node) . " - " . $node->get() . "<br>";
            }
            else {
                echo "$node <br>";
            }
        }
        */

        $result = $this->lexer($AST);

        echo $result;

    }

    public function lexer($AST) {
        // El lenguaje soporta unas construcciones limitadas

        // VAR [string] CLOSE
        // FOR [string] SEP [string] CLOSE CFOR
        // FOR [string] ARROW [string] SEP [string] CLOSE CFOR

        // IF [string][Syntax][string] SEP [string] SEP [string] CLOSE CIF
        // IF [string] SEP [string] SEP [string] CLOSE CIF
        // IF [string][Syntax][string] SEP [string] CLOSE CIF
        // IF [string] SEP [string] CLOSE CIF

        // Los IF cualquier string puede ir entre SQUOTE o DQUOTE. Error de sintaxis si solo va una de ellas
        // Las strings seran una variable en $data si no va entre quotes.
        // La string de FOR debe evaluar a numero
        // La primera string de FOR ARROW debe evaluar a array. La segunda string sera el nombre de la variable a usar dentro del loop

        $parentContext = null;
        $currentContext = null;
        $resultado = "";

        $left = false;
        $right = false;
        $squoted = false;
        $dquoted = false;

        foreach($AST as $token) {

            $klass = "";

            if (is_string($token)) {
                $klass = "string";
            }
            else {
                $klass = get_class($token);
            }

            switch ($klass) {

            case ("GestionComercial\CL\Parser\SyntaxToken"):

                $ttag = $token->get();

                switch ($ttag) {

                  case ('OPEN_TAG'):
                      $currentContext = new HtmlC();
                      break;

                  case ('CLOSE_TAG'):
                      $resultado .= $currentContext->getHtml();
                      break;

                  case ('EQ'):
                  case ('GREATER_EQ'):
                  case ('LESS_EQ'):
                  case ('GREATER'):
                  case ('LESS'):
                  case ('SLASH'):

                      //$ctx = get_class($currentContext);

                      //if($ctx = "GestionComercial\CL\Parser\Contexts\IfContext") {
                      //    $currentContext->addOp($ttag);
                      //}

                      break;

                  case ('DQUOTE'):

                      $dquoted = !$dquoted;
                      break;

                  case ('SQUOTE'):
                      $squoted = !$squoted;
                      break;
                }

                break;


                case ("GestionComercial\CL\Parser\CustomToken"):

                    $ttag = $token->get();

                    switch ($ttag) {
                      case ('IF'):
                          //$currentContext = new IfC($this->data);
                          break;
                      case ('FOR'):
                          //$currentContext = new ForC($this->data);
                          break;
                      case ('VAR'):
                          //$currentContext = new VarC($this->data);
                          break;

                      case ('CIF'):
                          //$resultado .= $currentContext->getHtml();
                          break;
                      case ('CFOR'):
                          break;
                      case ('SEP'):

                          break;
                      case ('CLOSE'):
                          //$resultado .= $currentContext->getHtml();
                          break;
                    }

                    break;

            case ("string"):
                // Segun el contexto hacemos lo que corresponda. Si es una string se comprueba que no tenga guiones y si los tiene que sea un componente o ser renderiza tal cual
                // For, esperamos un numero si no Error de Sintaxis
                   if ($currentContext == null)
                   {
                      break;
                   }

                   $ctx = get_class($currentContext);

                   switch ($ctx) {
                     case ("GestionComercial\CL\Parser\Contexts\ForContext"):

                         break;

                     case ("GestionComercial\CL\Parser\Contexts\IfContext"):

                         if (!$left && !$right) {
                             $left = true;
                             $currentContext->addLeftOp($token);
                         }

                         if ($left) {
                             $left = false;
                             $right = true;
                             $currentContext->addRightOp($token);
                         }

                         if ($right) {
                             // Sintax error
                         }

                         break;

                     case ("GestionComercial\CL\Parser\Contexts\VarContext"):

                         break;

                     case ("GestionComercial\CL\Parser\Contexts\ComponentContext"):

                         break;

                     case ("GestionComercial\CL\Parser\Contexts\HtmlContext"):
                         $currentContext->setTag($token);
                         break;
                }

                   break;
            }
        }

        return $resultado;
    }

    public function parser($tokens) {
        $tagFlag = false;
        $tag = "";
        $AST = [];

        foreach($tokens as $index => $token) {

            //echo "Processing " . $token->get() . " with type " . get_class($token) . "<br>";

            $klass = get_class($token);

            //print_r($token) . "<br>";

            /*
            // echo "EQ : " . $tokens[ $index - 1 ] . " = " . $tokens[ $index - 1 ]->get() . " <br>";

            if ($tokens[ $index - 1 ]->get() == 'OPEN_TAG') {

                array_pop($AST);

                $newToken = new SyntaxToken('LESSER_EQ_THAN');
                $AST[] = $newToken;

            }
            else if ($tokens[ $index -1 ]->get() == 'CLOSE_TAG') {

                $newToken = new SyntaxToken('GREATER_EQ_THAN');

                array_pop($AST);

                $AST[] = $newToken;

            }
            else {
                $AST[] = $token;
            }

            break;
            */

            switch ($klass) {

            case ("GestionComercial\CL\Parser\SyntaxToken"):

                    $ttag = $token->get();

                    switch ($ttag) {


                    case ('OPEN_TAG'):
                            $tagFlag = true;
                            $AST[] = $token;

                            break;
                    case ('CLOSE_TAG'):
                            $tagFlag = false;

                            $AST[] = $tag;
                            $tag = "";
                            $AST[] = $token;

                            break;

                    case ('EQ'):
                    case ('GREATER_EQ'):
                    case ('LESS_EQ'):
                    case ('GREATER'):
                    case ('LESS'):
                    case ('DQUOTE'):
                    case ('SQUOTE'):
                            $AST[] = $tag;
                            $tag = "";
                            $AST[] = $token;
                            break;

                    case ('SLASH'):
                            $tag .= '/';
                            break;
                    }
                    break;

                case ("GestionComercial\CL\Parser\CustomToken"):

                    // Desde FOR hasta CFOR
                        // Acumulo cadenas de texto desde FOR hasta SEP
                        // Acumulo cadenas de texto desde SEP hasta CFOR
                    // Desde VAR hasta CLOSE
                        // Acumulo cadenas de texto desde VAR hasta CLOSE
                    // Desde IF hasta CIF
                        // Acumulo cadenas de texto desde IF hasta SEP
                        // Acumulo cadenas de texto desde SEP hasta CIF
                    $ttag = $token->get();

                    switch ($ttag) {
                        case ('IF'):
                        case ('FOR'):
                        case ('VAR'):
                            $AST[] = $token;
                            $tagFlag = true;
                            break;

                        case ('CIF'):
                        case ('CFOR'):
                        case ('SEP'):
                        case ('CLOSE'):
                            $tagFlag = false;

                            $AST[] = $tag;
                            $tag = "";
                            $AST[] = $token;

                            break;
                    }

                    break;

                case ("GestionComercial\CL\Parser\CharToken"):
                    // Acumulo cadenas de texto desde OPEN_TAG hasta CLOSE_TAG
                    //if ($tagFlag) {
                        $tag .= $token->get();
                    //}

                    break;
            }
        }

        return $AST;
    }
    public function tokenizer() {

         // Dependiendo del token tenemos que acturar
                // Si el token es VAR_SYMBOL se ha de sustituir en la salida la variable por su valor correspondiente (haria falta que recibiera tambien los datos)
                // Si el tone es un FOR_SYMBOL, var tiene el numero de iteraciones y al siguiente SEPARATOR, se repite el bloque pasado (hayn que tener en cuenta que puede tener mas variables y fors e ifs)
                // Si es un IF_SYMBOL se evalua que se cumpla la condicion var op val y se ejecuta el primer o el segundo bloque segun convenga, parseando el bloque
                // En los casos de FOR e IF se ejecutar un nuevo parser y se salta hasta el cierre en el principal, insertando el resultado en su lugar

                // @[var | <code> ] -> List Comprehension
                // $[var] => Var use
                // ?[var op val | <true cond code> | <false cond code, optional> -> If

                // CLOSE_BRACKET indica el cierre de un bloque a evaluar y no se debe incluir en el bloque a evaluar
                // SEPARATOR_TOKEN separa en el FOR y el IF los bloques a evaluar. Si en el IF solo hay un bloque sera para TRUE, no incluyendo nada en caso contrario
                // El segundo SEPARATOR_TOKEN en ese caso es opcional

        $char = '';
        $this->asArray =  str_split(trim($this->input));
        $AST = [];

        $payload = null;
        $current_token = -1;

        while(true) {

            $char = $this->asArray[$this->currentpos];

            //echo "Processing $char <br>";

            $token = $this->getToken($char);


            switch ($token) {
                case (self::VAR_SYMBOL):
                    $AST[] = new CustomToken('VAR');
                    break;
                case (self::CLOSE_BRACKET):
                    $AST[] = new CustomToken('CLOSE');
                    break;
                case(self::FOR_SYMBOL):
                    $AST[] = new CustomToken('FOR');
                    break;

                case(self::IF_SYMBOL):
                    $AST[] = new CustomToken('IF');
                    break;

                case(self::OPEN_BRACKET):
                    $AST[] = new CustomToken('OPEN');
                    break;

                case(self::SEPARATOR_TOKEN):
                    $AST[] = new CustomToken('SEP');
                    break;

                case(self::EQUAL):
                    $AST[] = new SyntaxToken('EQ');
                    break;

                case(self::GREATER_EQ_THAN):
                    array_pop($AST); 
                    $AST[] = new SyntaxToken('GREATER_EQ');
                    break;
                case(self::LESS_EQ_THAN):
                    array_pop($AST);
                    $AST[] = new SyntaxToken('LESS_EQ');
                    break;
                case(self::GREATER_THAN):
                    $AST[] = new SyntaxToken('GREATER');
                    break;

                case(self::LESS_EQ_THAN):
                    $AST[] = new SyntaxToken('LESS');
                    break;

                case(self::CLOSE_FOR_SYMBOL):
                    $AST[] = new CustomToken('CFOR');
                    break;

                case(self::CLOSE_IF_SYMBOL):
                    $AST[] = new CustomToken('CIF');
                    break;
                case(self::CHAR):
                    $AST[] = new CharToken($char);
                    break;
                case(self::OPEN_ANGLE_BRACKETS):
                    $AST[] = new SyntaxToken('OPEN_TAG');
                    break;
                case(self::CLOSE_ANGLE_BRACKETS):
                    $AST[] = new SyntaxToken('CLOSE_TAG');
                    break;
                case(self::SLASH):
                    $AST[] = new SyntaxToken('SLASH');
                    break;
                case(self::DOUBLE_QUOTE):
                    $AST[] = new SyntaxToken('DQUOTE');
                    break;
                case(self::SINGLE_QUOTE):
                    $AST[] = new SyntaxToken('SQUOTE');
                    break;
            }

            $this->currentpos++;

            if ($this->currentpos >= count($this->asArray)) {
                break;
            }
        }

        //echo "AST <br>";

        return $AST;
    }

    private function getToken($char) {

        $result = null;

        //echo "Looking for $char <br>";

        switch ($char) {
            case ('$'):
                if ($this->lookAhead() == self::OPEN_BRACKET) {
                    $this->skipNext();
                    $result = self::VAR_SYMBOL;
                }
                else {
                    $result =  $char;
                }

                break;
            case ('@'):
                if ($this->lookAhead() == self::OPEN_BRACKET) {
                    $this->skipNext();
                    $result = self::FOR_SYMBOL;
                }
                else if ($this->lookBefore() == self::CLOSE_BRACKET) {
                    $this->skipNext();
                    $result = self::CLOSE_FOR_SYMBOL;

                }
                else {
                    $result = $char;
                }
                break;

            case ('?'):
                if ($this->lookAhead() == self::OPEN_BRACKET) {
                    $this->skipNext();
                    $result = self::IF_SYMBOL;
                }
                else if ($this->lookBefore() == self::CLOSE_BRACKET) {
                    $this->skipNext();
                    $result = self::CLOSE_IF_SYMBOL;

                }
                else {
                    $result = $char;
                }

                break;

            case ('['):
                //$this->skipNext();
                $result = self::OPEN_BRACKET;

                break;

            case (']'):
                $result = self::CLOSE_BRACKET;

                break;

            case ('|'):
                $result = self::SEPARATOR_TOKEN;

                break;
            case ('='):

                if ($this->lookBefore() == self::OPEN_ANGLE_BRACKETS) {
                    $result = self::LESS_EQ_THAN;
                }
                else if ($this->lookBefore() == self::CLOSE_ANGLE_BRACKETS) {
                    $result = self::GREATER_EQ_THAN;
                }
                else {
                    $result = self::EQUAL;
                }

                break;

            case (' '):
                $result = self::BLANK_SYMBOL;

                break;
            case ('<'):
                $result = self::OPEN_ANGLE_BRACKETS;

                break;

            case ('>'):
                $result = self::CLOSE_ANGLE_BRACKETS;

                break;

            case ('/'):
                $result = self::SLASH;

                break;
            case ('"'):
                $result = self::DOUBLE_QUOTE;

                break;
            case ("'"):
                    $result = self::SINGLE_QUOTE;

                    break;
            case ('0'):
                $result = self::CHAR;

                break;

            case (ctype_alnum($char)):
                $result = self::CHAR;

                break;
        }

        //echo "Found $result <br>";
        //echo $this->currentpos . "/" . count($this->asArray) . " - $char <br>";

        return $result;
    }

    private function skipNext() {
        $this->currentpos++;
    }

    private function lookAhead() {

        $char = $this->asArray[$this->currentpos + 1];

        //echo "Looking ahead for $char <br>";

        return $this->getToken($char);

    }

    private function lookBefore() {

        $char = $this->asArray[$this->currentpos - 1];

        //echo "Looking before for $char <br>";

        return $this->getToken($char);
    }
}

?>
