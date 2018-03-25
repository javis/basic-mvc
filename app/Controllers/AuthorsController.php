<?php
namespace App\Controllers;
use Core\MVC\BaseController;
use App\Models\Author;

class AuthorsController extends BaseController{
    public function index()
    {
        $authors = Author::where('id','>', 0)->lists('full_name');
        return json_encode($authors);
    }
}
