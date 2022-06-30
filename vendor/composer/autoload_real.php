<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitfca18ff1edd9fce0f35bc4b9397ad687
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitfca18ff1edd9fce0f35bc4b9397ad687', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitfca18ff1edd9fce0f35bc4b9397ad687', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitfca18ff1edd9fce0f35bc4b9397ad687::getInitializer($loader));

        $loader->setClassMapAuthoritative(true);
        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInitfca18ff1edd9fce0f35bc4b9397ad687::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequirefca18ff1edd9fce0f35bc4b9397ad687($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequirefca18ff1edd9fce0f35bc4b9397ad687($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
