<?php

/**
 * This is a namespace Alias autoload example
 */

// call the Cliprz\Loader\Autoload
include ('../../Autoload.php');

// Use the Cliprz\Loader\Autoload namespace
use Cliprz\Loader\Autoload;

// Current directory
$__dir = __DIR__.DIRECTORY_SEPARATOR;

// Set a core classes path
// as in example you will get Current\directory\Testing\Alias
Autoload::setCore($__dir);

// Adds a single class map
Autoload::addMap('This\\Is\\Alias\\Example\\Foo',$__dir.'Foo.php');
Autoload::addMap('This\\Is\\Alias\\Example\\Bar',$__dir.'Bar.php');

// register Cliprz\Loader\Autoload class in SPL stack
Autoload::register();

// Make short namespace, now we can only use Foo
Autoload::namespaceAlias('This\\Is\\Alias\\Example\\Foo');
Autoload::namespaceAlias('This\\Is\\Alias\\Example\\Bar','My');

// Now you can use Foo not the long namespace This\\Is\\Alias\\Example\\Foo
$foo = new Foo();
$bar = new My\Bar();

$foo->printMe();
$bar->printMe();

// un register Cliprz\Loader\Autoload from SPL stack
Autoload::unRegister();

?>