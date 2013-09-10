<?php

/**
 * This is a class map autoload example
 */

// call the Cliprz\Loader\Autoload
include ('../../Autoload.php');

// Use the Cliprz\Loader\Autoload namespace
use Cliprz\Loader\Autoload;

// Current directory
$__dir = __DIR__.DIRECTORY_SEPARATOR;

// Set a core classes path
// as in example you will get Current\directory\Testing\Map
Autoload::setCore($__dir);

// If you wan't to add a single map in Cliprz\Loader\Autoload classes map
// Use Cliprz\Loader\Autoload::addMap() method
#Autoload::addMap('Classname',$__dir.'Path/to/class.php');
// But we are use Cliprz\Loader\Autoload::addMaps() to add multi class map
$classMap = [
    'Foo'        => $__dir.'Classes/Foo.php',
    'Bar'        => $__dir.'Classes/Bar.php',
    'Core'       => $__dir.'Includes/Core.php',
    // You can use namespaces but we prefer to use PSR-0 standard and use mapping
    'PSR0\A\Any' => $__dir.'PSR0/A/Any.php',
    'PSR0\B\Bar' => $__dir.'PSR0/B/Bar.php',
    'PSR0\F\Foo' => $__dir.'PSR0/F/Foo.php'
];

Autoload::addMaps($classMap);

// register Cliprz\Loader\Autoload class in SPL stack
Autoload::register();

// Here i will load some classes
$foo  = new Foo();
$bar  = new Bar();
$core = new Core();
$nsAny = new PSR0\A\Any();
$nsBar = new PSR0\B\Bar();
$nsFoo = new PSR0\F\Foo();

// Some testing
$foo->printMe();
$bar->printMe();
$core->printMe();
$nsAny->printMe();
$nsBar->printMe();
$nsFoo->printMe();

// un register Cliprz\Loader\Autoload from SPL stack
Autoload::unRegister();

?>