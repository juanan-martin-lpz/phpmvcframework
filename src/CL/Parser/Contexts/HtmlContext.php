<?php

namespace GestionComercial\CL\Parser\Contexts;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class HtmlContext implements IContext {

    private $tag;

    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    public function getHtml(): string {

        $result = "&lt;$this->tag&gt;";
        return $result;

    }
}
?>
