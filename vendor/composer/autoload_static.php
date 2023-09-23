<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9d6af050f0e6e86420d25ea3c3afe16f
{
    public static $classMap = array (
        'Tanvir\\Plugin\\Base' => __DIR__ . '/../..' . '/src/Base.php',
        'Tanvir\\Plugin\\Deactivator' => __DIR__ . '/../..' . '/src/Deactivator.php',
        'Tanvir\\Plugin\\Feature' => __DIR__ . '/../..' . '/src/Feature.php',
        'Tanvir\\Plugin\\Fields' => __DIR__ . '/../..' . '/src/Fields.php',
        'Tanvir\\Plugin\\License' => __DIR__ . '/../..' . '/src/License.php',
        'Tanvir\\Plugin\\Metabox' => __DIR__ . '/../..' . '/src/Metabox.php',
        'Tanvir\\Plugin\\Notice' => __DIR__ . '/../..' . '/src/Notice.php',
        'Tanvir\\Plugin\\Settings' => __DIR__ . '/../..' . '/src/Settings.php',
        'Tanvir\\Plugin\\Setup' => __DIR__ . '/../..' . '/src/Setup.php',
        'Tanvir\\Plugin\\Survey' => __DIR__ . '/../..' . '/src/Survey.php',
        'Tanvir\\Plugin\\Table' => __DIR__ . '/../..' . '/src/Table.php',
        'Tanvir\\Plugin\\Update' => __DIR__ . '/../..' . '/src/Update.php',
        'Tanvir\\Plugin\\Widget' => __DIR__ . '/../..' . '/src/Widget.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit9d6af050f0e6e86420d25ea3c3afe16f::$classMap;

        }, null, ClassLoader::class);
    }
}