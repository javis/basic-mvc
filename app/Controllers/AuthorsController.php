<?php
namespace App\Controllers;
use App\Models\Author;

class AuthorsController extends BaseController{
    public static function index()
    {
        $authors = new Author();
        $authors = $authors->getAll();
        $authors = array_map(function($author){
            return $author['full_name'];
        },$authors);

        die(json_encode($authors));
    }
}
