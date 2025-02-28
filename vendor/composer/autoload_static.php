<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit176d97847e93182c4d6d11811e438dc5
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Config\\' => 7,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Config',
        ),
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit176d97847e93182c4d6d11811e438dc5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit176d97847e93182c4d6d11811e438dc5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit176d97847e93182c4d6d11811e438dc5::$classMap;

        }, null, ClassLoader::class);
    }
}
