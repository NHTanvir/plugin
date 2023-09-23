<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit85f800c92a26f4646b603c2e88f1ef44
{
    public static $classMap = array (
        'Tanvir10\\Plugin\\Base' => __DIR__ . '/../..' . '/src/Base.php',
        'Tanvir10\\Plugin\\Deactivator' => __DIR__ . '/../..' . '/src/Deactivator.php',
        'Tanvir10\\Plugin\\Feature' => __DIR__ . '/../..' . '/src/Feature.php',
        'Tanvir10\\Plugin\\Fields' => __DIR__ . '/../..' . '/src/Fields.php',
        'Tanvir10\\Plugin\\License' => __DIR__ . '/../..' . '/src/License.php',
        'Tanvir10\\Plugin\\Metabox' => __DIR__ . '/../..' . '/src/Metabox.php',
        'Tanvir10\\Plugin\\Notice' => __DIR__ . '/../..' . '/src/Notice.php',
        'Tanvir10\\Plugin\\Settings' => __DIR__ . '/../..' . '/src/Settings.php',
        'Tanvir10\\Plugin\\Setup' => __DIR__ . '/../..' . '/src/Setup.php',
        'Tanvir10\\Plugin\\Survey' => __DIR__ . '/../..' . '/src/Survey.php',
        'Tanvir10\\Plugin\\Table' => __DIR__ . '/../..' . '/src/Table.php',
        'Tanvir10\\Plugin\\Update' => __DIR__ . '/../..' . '/src/Update.php',
        'Tanvir10\\Plugin\\Widget' => __DIR__ . '/../..' . '/src/Widget.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit85f800c92a26f4646b603c2e88f1ef44::$classMap;

        }, null, ClassLoader::class);
    }
}
