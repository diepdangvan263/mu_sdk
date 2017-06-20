<?php

/* Base config */
error_reporting(E_ALL);
date_default_timezone_set('Asia/Ho_Chi_Minh'); //current timezone
session_start(); //start session
header('Content-Type: text/html; charset=utf-8');

define('ALLOWED_ACCESS', 1);
define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__FILE__) . DS);

define('APP_PATH', BASE_PATH . 'application' . DS);
define('CONFIG_PATH', BASE_PATH . 'config' . DS);
define('LIB_PATH', BASE_PATH . 'lib' . DS);

/* Autoload Function */
function __autoload($class)
{
	$file = strtolower(str_replace('_', DS, $class) . '.php');
	if (file_exists(APP_PATH . $file)) {
		require_once APP_PATH . $file;
	} elseif (file_exists(LIB_PATH . $file)) {
		require_once LIB_PATH . $file;
	} elseif (file_exists($file)) {
		require_once $file;
	}
}

/* Register variable to registry */
$registry = new Registry();
$registry['config'] = include CONFIG_PATH . 'application.php';

/* Set Language */
Language::setLanguage($registry['config']['language']);

/* Start application */
new Route(include CONFIG_PATH . 'route.php');

session_destroy(); // close session