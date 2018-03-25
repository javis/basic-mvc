<?php
/**
* App single point entry
*/
use Core\Router;
// include composer autoload and Framework bootstrap
require_once '../vendor/autoload.php';

set_exception_handler('Core\Error::exceptionHandler');

// routes current URL path
$router = Router::getInstance();

// tries to match current URL to a registered route
$callback = $router->route($_SERVER['REQUEST_METHOD'],$_SERVER['REQUEST_URI']);

if (!$callback){
    // respond Not Found
    header('HTTP/1.0 404 Not Found', true, 404);
    die("Page Not Found");
}
else{
    list($callable,$args) = $callback;
    call_user_func_array($callable,$args);
}
