<?php
namespace App\Controllers;
use App\Models\Author;

class AuthorsController extends BaseController{
    public static function index()
    {
        $authors = Author::where('id','>', 0)->lists('full_name');
        return json_encode($authors);
    }
}
