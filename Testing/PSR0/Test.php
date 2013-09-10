<?php

/**
 * This is a PSR-0 autoload example
 */

// call the Cliprz\Loader\Autoload
include ('../../Autoload.php');

// Use the Cliprz\Loader\Autoload namespace
use Cliprz\Loader\Autoload;

// Current directory
$__dir = __DIR__.DIRECTORY_SEPARATOR;

// Set a core classes path
// as in example you will get Current\directory\Testing\PSR0\
Autoload::setCore($__dir);

// register Cliprz\Loader\Autoload class in SPL stack
Autoload::register();

// Here i will load some classes
$any = new Classes\A\Any();
$bar = new Classes\B\Bar();
$foo = new Classes\F\Foo();

// Some testing
$any->printMe();
$bar->printMe();
$foo->printMe();

// un register Cliprz\Loader\Autoload from SPL stack
Autoload::unRegister();

?>