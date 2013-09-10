<?php

/**
 * Cliprz framework
 *
 * An open source application development framework for PHP 5.4.0 or newer
 *
 * @package    Cliprz
 * @author     Yousef Ismaeil <cliprz@gmail.com>
 * @copyright  Copyright (c) 2013 - 2014, Cliprz Developers team
 * @license    MIT
 * @link       http://www.cliprz.org
 * @version    1.0.0
 */

namespace Cliprz\Loader;

/**
 * Maybe you install this class from Composer so we make sure you don't use class twice
 */
if (class_exists('Cliprz\Loader\Autoload')) return;

final class Autoload {

    /**
     * Core namespace
     *
     * @const string
     */
    #const CNS = 'Cliprz\\'; // Only in Cliprz framework

    /**
     * Namespace separator
     *
     * @const string
     */
    const SEPARATOR = '\\';

    /**
     * Core path that's search for classes in first place
     *
     * @var string|null
     * @access private
     * @static
     */
    private static $corePath;

    /**
     * Holds all classes and paths
     *
     * @var array
     * @access private
     * @static
     */
    private static $classMap = [];

    /**
     * Holds fallback directories
     * Research for class in fallback directories if not exist in the core directory
     *
     * @var array
     * @access private
     * @static
     */
    private static $fallbackMap = [];

    /**
     * Set the core path
     *
     * @param string path
     * @access public
     * @static
     * @return void
     */
    public static function setCore ($path) {
        static::$corePath = rtrim(rtrim($path,DIRECTORY_SEPARATOR),'/')
            .DIRECTORY_SEPARATOR;
    }

    /**
     * Get the core path
     *
     * @access private
     * @static
     * @return string core path or null in otherwise
     */
    private static function getCore () {
        return static::$corePath;
    }

    /**
     * Adds single class map
     *
     * @param string class name
     * @param string directory path
     * @static
     * @return void
     */
    public static function addMap ($class,$path) {
        if (!array_key_exists($class,static::$classMap)) {
            static::$classMap[$class] = $path;
        }
    }

    /**
     * Adds mutli classes maps
     *
     * @param array class name => directory path
     * @access public
     * @static
     * @return void
     */
    public static function addMaps ($classes) {
        if (is_array($classes)) {
            foreach ($classes as $class => $path) {
                if (array_key_exists($class,static::$classMap)) {
                    continue;
                }
                static::$classMap[$class] = $path;
            }
        }
    }

    /**
     * Get all classes and paths
     *
     * @access public
     * @static
     * @return array
     */
    public static function getClassMap () {
        return (array) static::$classMap;
    }

    /**
     * Set fallback map
     *
     * @param string directory
     * @access public
     * @static
     * @return void
     */
    public static function setFallback (Array $fallback) {
        static::$fallbackMap = array_merge($fallback,static::$fallbackMap);
    }

    /**
     * Get fallback map
     *
     * @access public
     * @static
     * @return array
     */
    public static function getFallback () {
        return (array) static::$fallbackMap;
    }

    /**
     * Our autoload method, load classes or interfaces
     *
     * @param string class name
     * @static
     * @return boolean true if class loaded or false in otherwise
     */
    public static function load ($class) {
        if ($file = static::search($class)) {
            if (is_file($file)) {
                include ($file);
                return true;
            }
        }
        return false;
    }

    /**
     * Search for classes
     * A really good method to find class or research for class in fallback
     *
     * @param string class name
     * @access private
     * @static
     * @return string class path or false in otherwise
     */
    private static function search($class) {
        // Firstly: if class exists in map return to class path
        if (array_key_exists($class,static::$classMap)) {
            return static::$classMap[$class];
        }

        // Secondly: if class not exists in map

        // Checking if class loaded as PSR-0 standard or Set class name with .php suffix
        $classPath = (false !== $position = strrpos($class,self::SEPARATOR))
            ? static::PSR0($class,$position) : $class.'.php';

        // Tell the autoload if use PSR-0 or not
        $isPSR0 = (boolean) ((false !== $position) ? true : false);

        // Try to search for class from core path
        if (null != static::getCore()) {
            if (is_file(static::getCore().$classPath)) {
                return static::getCore().$classPath;
            }
        }

        // class still not exists !!
        // Here we use the fallback map to research for class
        if (!empty(static::getFallback())) {
            // Get clean class name without any namespaces
            if ($isPSR0) {
                $classPath = ltrim(substr($classPath,$position + 1),self::SEPARATOR);
            }
            // Loop the fallback until find the class or return false in the end of method
            foreach (static::getFallback() as $path) {
                if (is_file($path.DIRECTORY_SEPARATOR.$classPath)) {
                    return $path.DIRECTORY_SEPARATOR.$classPath;
                    break;
                }
            }
        }

        return false;
    }

	/**
	 * PSR-0 standard, Replace namespace with full path to class
	 *
	 * @param string class name
	 * @param boolean|integer the namespace positions
	 * @access private
	 * @static
	 * @return string PSR-0 class path
	 */
    private static function PSR0 ($class,$position) {
        // Remove any SEPARATOR in starting
        $class = ltrim($class,self::SEPARATOR);
        // Get a clean file path to follow PSR-0 standard
        $file  = static::preparePath(substr($class,0,$position)).DIRECTORY_SEPARATOR;
        // Get class name
        $class = substr($class,$position + 1);
        // Fix any _ mark with DIRECTORY_SEPARATOR to follow PSR-0 standard and add .php suffix
        $file .= str_replace('_',DIRECTORY_SEPARATOR,$class).'.php';
        // Now we get a clean PSR-0 standard file path
        return $file;
    }

    /**
     * Make sure using the best operating system directory separators in path
     *
     * @param string path
     * @access private
     * @static
     * @return string
     */
    private static function preparePath ($path) {
        return str_replace(array('/',self::SEPARATOR),DIRECTORY_SEPARATOR,$path);
    }

    /**
     * Creates an alias for a namespace
     *
     * @param string The original class
     * @param string The new namespace for this class
     * @access public
     * @static
     */
    public static function namespaceAlias($original,$alias=null) {
        $alias = ((isset($alias)) ? rtrim($alias,self::SEPARATOR).self::SEPARATOR : $alias);
        // Get clean class name without any namespaces
        $alias = $alias.array_pop(explode(self::SEPARATOR,$original));
        class_alias($original,$alias);
    }

	/**
	 * Install our autoloader on the SPL autoload stack
	 *
	 * @param boolean Whether to prepend the autoloader or not
	 * @access public
	 * @static
	 */
	public static function register ($prepend=false) {
		spl_autoload_register(__NAMESPACE__.self::SEPARATOR.'Autoload::load',true,$prepend);
	}

	/**
	 * Uninstall our autoloader from the SPL autoload stack
	 *
	 * @access public
	 */
	public static function unRegister () {
		spl_autoload_unregister(__NAMESPACE__.self::SEPARATOR.'Autoload::load');
	}

}

?>