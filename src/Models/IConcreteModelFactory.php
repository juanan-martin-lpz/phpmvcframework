<?php

interface IConcreteModelFactory {
    static function fromAssoc($data);
    static function create();
}



?>
