<?php
use Core\Router;

use App\Controllers\{BooksController,AuthorsController};
/**
 * In this file we define the routes of the app
 */

$router = Router::getInstance();

// List all books
$router->add(['get'],'/',[BooksController::class,'index']);
// removes one book
$router->add(['get'],'books/{id}/delete',[BooksController::class,'delete']);
// show books creation form
$router->add(['get'],'books/add',[BooksController::class,'create']);
// stores book info on DB
$router->add(['post'],'books/add',[BooksController::class,'store']);
// show books
$router->add(['get'],'books/{id}',[BooksController::class,'view']);
// stores book info on DB
$router->add(['post'],'books/{id}',[BooksController::class,'store']);

// authors
$router->add(['get'],'authors.json',[AuthorsController::class,'index']);
