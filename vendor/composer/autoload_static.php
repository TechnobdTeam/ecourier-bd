<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb850692db4c640680afabb9c77dcf235
{
    public static $prefixesPsr0 = array (
        'E' => 
        array (
            'ECourierBD' => 
            array (
                0 => __DIR__ . '/../..' . '/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitb850692db4c640680afabb9c77dcf235::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
