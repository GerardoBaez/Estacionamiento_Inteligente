<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit21b71563f1a34337d88eb7d413702233
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sonata\\GoogleAuthenticator\\' => 27,
        ),
        'G' => 
        array (
            'Google\\Authenticator\\' => 21,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sonata\\GoogleAuthenticator\\' => 
        array (
            0 => __DIR__ . '/..' . '/sonata-project/google-authenticator/src',
        ),
        'Google\\Authenticator\\' => 
        array (
            0 => __DIR__ . '/..' . '/sonata-project/google-authenticator/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit21b71563f1a34337d88eb7d413702233::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit21b71563f1a34337d88eb7d413702233::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit21b71563f1a34337d88eb7d413702233::$classMap;

        }, null, ClassLoader::class);
    }
}