<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','on');

// Define path to application directory 
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '../application'));
//var_dump('APPLICATION_PATH', realpath(dirname(__FILE__))); "/home/luxucom/public_html/JogosEmpresa/public" 

// Define application environment
defined('APPLICATION_ENV')  || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '../library'),get_include_path(),)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run  ||  APPLICATION_PATH . '/configs/application.ini'
$application = new Zend_Application(
    APPLICATION_ENV,
    '/home/luxucom/public_html/JogosEmpresa/application/configs/application.ini'
);

$application->bootstrap()
            ->run();
?>