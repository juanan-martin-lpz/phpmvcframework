<?php

namespace MVCLite\Registry;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';


class ComponentRegistry {

    static public $components = [];

    static public function add(string $key, string $component) {

        self::$components[$key] = $component;
    }

    static public function remove(string $key) {

        unset(self::$components[$key]);
    }

    static public function get($key): string {

        if (self::$components[$key] != "") {
            return self::$components[$key];
        }
        else {
            return "";
        }
    }
}
?>
