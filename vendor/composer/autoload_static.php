<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf93f5d152ba55cb49377fa617f569a35
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'GestionComercial\\Views\\' => 23,
            'GestionComercial\\Models\\' => 24,
            'GestionComercial\\Controllers\\' => 29,
            'GestionComercial\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'GestionComercial\\Views\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Views',
        ),
        'GestionComercial\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Models',
        ),
        'GestionComercial\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Controllers',
        ),
        'GestionComercial\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf93f5d152ba55cb49377fa617f569a35::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf93f5d152ba55cb49377fa617f569a35::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf93f5d152ba55cb49377fa617f569a35::$classMap;

        }, null, ClassLoader::class);
    }
}