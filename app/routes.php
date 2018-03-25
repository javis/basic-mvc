<?php
use Core\Router;

use App\Controllers\{HomeController};
/**
 * In this file we define the routes of the app
 */

$router = Router::getInstance();

$router->add(['get'],'/',[HomeController::class, 'index']);
