<?php

//Connect to database
define('DB_TYPE', 'mysql');
define('DB_NAME', 'classquizz');
define('DB_USER', 'vutaviva');
define('DB_PASSWORD','123456789');
define('DB_HOST', 'localhost');

//Captcha keys
define('CAPTCHA_PUBLIC_KEY','6LdcZAMTAAAAANu7xyOgrjA6I3a9UAdMsK-hmRR2');
define('CAPTCHA_PRIVATE_KEY','6LdcZAMTAAAAAOgP0BFoCsoA3vhdN0js8d5Mdzkk');
define ('CAPTCHA_SERVER', 'https://www.google.com/recaptcha/api/siteverify?secret=' . CAPTCHA_PRIVATE_KEY);

//Development Environment
define('DEBUGGING',true);

//Base URL
define('BASE_URL','//localhost/');

//Path to folder
define('ROOT_PATH',realpath(dirname(__FILE__).'/../..') . '/');

define('APPLICATION_PATH',ROOT_PATH . 'application/');
    define('CONTROLLER_PATH',APPLICATION_PATH . 'controllers/');
    define('MODEL_PATH',APPLICATION_PATH . 'models/');
    define('VIEW_PATH',APPLICATION_PATH . 'views/');

define('PUBLIC_PATH',ROOT_PATH . 'public/');

define ('VENDOR_PATH', ROOT_PATH . 'vendor/');

//Constants in Session

//autoload function
function autoLoad($class)
{
    if (file_exists('../Application/Core/' . strtolower($class) . '.php')) {
        require_once('../Application/Core/' . strtolower($class) . '.php');
    } elseif (file_exists('../Application/Models/' . strtolower($class) . '.php')) {
        require_once('../Application/Models/' . strtolower($class) . '.php');
    } elseif (file_exists('../Application/Controllers/' . strtolower($class) . '.php')) {
        require_once('../Application/Controllers/' . strtolower($class) . '.php');
    } elseif (file_exists('../Application/Services/' . strtolower($class) . '.php')) {
        require_once('../Application/Services/' . strtolower($class) . '.php');
    } elseif (file_exists('../Application/Utilities/' . strtolower($class) . '.php')) {
        require_once('../Application/Utilities/' . strtolower($class) . '.php');
    } elseif (file_exists('../Application/' . strtolower($class) . '.php')) {
        require_once('../Application/' . strtolower($class) . '.php');
    }
}

spl_autoload_register('autoLoad');
