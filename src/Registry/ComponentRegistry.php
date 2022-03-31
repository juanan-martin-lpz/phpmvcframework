<?php

namespace MVCLite\Registry;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


class ComponentRegistry {

    public static $components;

    public static function add(string $key, string $component) {

        self::$components[$key] = $component;
    }

    public static function remove(string $key) {

        unset(self::$components[$key]);
    }

    public static function get($key): string {

        if (self::$components[$key] != "") {
            return self::$components[$key];
        }
        else {
            return "";
        }
    }
}
?>
