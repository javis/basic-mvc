<?php
/**
* App single point entry
*/
use Core\Router;

session_start();

// include composer autoload and Framework bootstrap
require_once '../vendor/autoload.php';

set_exception_handler('Core\Error::exceptionHandler');

// routes current URL path
$router = Router::getInstance();

// fixes $_GET variable after URL rewrite
$parsed_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($parsed_url['query']??'', $output);
$_GET = array_merge($_GET, $output);
if (!isset($_GET['url'])){
    $_GET['url'] = '';
}

// tries to match current URL to a registered route
$callback = $router->route($_SERVER['REQUEST_METHOD'],$_GET['url']);

if (!$callback){
    // respond Not Found
    header('HTTP/1.0 404 Not Found', true, 404);
    die("Not Found");
}
else{
    list($callable,$args) = $callback;
    call_user_func_array($callable,$args);
}
