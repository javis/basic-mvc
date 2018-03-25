<?php
use Core\Router;
/**
 * In this file we define the routes of the app
 */

$router = Router::getInstance();

$router->add(['get'],'/',function(){
    echo"Hi!";
});
