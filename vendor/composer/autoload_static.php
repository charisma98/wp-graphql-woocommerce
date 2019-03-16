<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2d555d78ee082f72358dcb4e8879c82f
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPGraphQL\\Extensions\\WooCommerce\\' => 33,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPGraphQL\\Extensions\\WooCommerce\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2d555d78ee082f72358dcb4e8879c82f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2d555d78ee082f72358dcb4e8879c82f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
