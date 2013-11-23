<?php

$psr0 = 'Treeweb\\Bundle\\TreewebValidationBundle';

// autoload everything we can with composer
if (!@include( __DIR__ . '/../vendor/autoload.php')) {
    die("You must set up the project dependencies, run the following commands:
wget http://getcomposer.org/composer.phar
php composer.phar install
");
}

// manually autoload our bundle PSR-0 namespace
spl_autoload_register(function($class, $psr0) {
    if (0 === (strpos($class, $psr0 .'\\'))) {
        $path = __DIR__.'/../'.implode('/', array_slice(explode('\\', $class), 3)).'.php';

        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;
        return true;
    }
});
