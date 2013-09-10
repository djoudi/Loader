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
// as in example you will get Current\directory\Testing\Simple\Classes
Autoload::setCore($__dir.'Classes');

// register Cliprz\Loader\Autoload class in SPL stack
Autoload::register();

// Here i will load some classes
$foo = new Foo();
$bar = new Bar();

// Some testing
$foo->printMe();
$bar->printMe();

// un register Cliprz\Loader\Autoload from SPL stack
Autoload::unRegister();

?>