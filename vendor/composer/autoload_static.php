<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit09d7493ee1ef1d984923d76878dacb46
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BigBlueButton\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BigBlueButton\\' => 
        array (
            0 => __DIR__ . '/..' . '/bigbluebutton/bigbluebutton-api-php/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit09d7493ee1ef1d984923d76878dacb46::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit09d7493ee1ef1d984923d76878dacb46::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
