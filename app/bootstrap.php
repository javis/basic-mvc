<?php
/**
 * This file setups the environment of the app
 */

// Root path for inclusion.
define('APP_ROOT', dirname(__DIR__));

// register error handler
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');

// set the application base path for the Views to find the templates
Core\MVC\View::setAppPath(APP_ROOT);

// load the App routes
include APP_ROOT.'/app/routes.php';
