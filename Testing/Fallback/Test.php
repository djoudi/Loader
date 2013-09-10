<?php

/**
 * This is a simple autoload example
 */

// call the Cliprz\Loader\Autoload
include ('../../Autoload.php');

// Use the Cliprz\Loader\Autoload namespace
use Cliprz\Loader\Autoload;

// Current directory
$__dir = __DIR__.DIRECTORY_SEPARATOR;

// Set a core classes path
// as in example you will get Current\directory\Testing\Fallback\Classes
Autoload::setCore($__dir.'Classes');

// Here we set some paths of class does not exist in core path
// We use Cliprz\Loader\Autoload::setFallback() method
Autoload::setFallback([
    $__dir.'Others'
]);

// NOTE : Cliprz\Loader\Autoload::setFallback() parameters must be an array

// register Cliprz\Loader\Autoload class in SPL stack
Autoload::register();

// Here i will load some classes
$foo = new Foo();
$bar = new Bar();
$simple = new Simple();

// Some testing
$foo->printMe();
$bar->printMe();
$simple->printMe();

// un register Cliprz\Loader\Autoload from SPL stack
Autoload::unRegister();

?>