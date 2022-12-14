<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc3b87f35ac88f340714a5764c25ea50a
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'ChangePublishDate\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ChangePublishDate\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc3b87f35ac88f340714a5764c25ea50a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc3b87f35ac88f340714a5764c25ea50a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc3b87f35ac88f340714a5764c25ea50a::$classMap;

        }, null, ClassLoader::class);
    }
}
