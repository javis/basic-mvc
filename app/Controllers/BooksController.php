<?php
namespace App\Controllers;
use App\Models\{Book,Author};

class BooksController extends BaseController{
    public static function index()
    {
        $search = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        // retrieves the books
        $books = new Book();

        if ($search){
            $books = $books->titleLike($search);
        }
        else{
            $books = $books->getAll();
        }
        // render the template
        self::render('index.html',[
            'books' => $books,
            'search' => $search
        ]);
    }

    public static function delete($id)
    {
        $books = new Book();
        if ($books->delete($id)){
            self::flash('Book removed successfully');
        }
        else
        {
            self::flash("No book was found with id $id" , "error");
        }
        // redirects to listing
        header("Location: /");
        die();
    }

    public static function create()
    {
        self::render('book.html');
    }

    public static function view($id)
    {
        $books = new Book();
        $authors = new Author();
        $book = $books->get($id);
        if (!$book){
            header('HTTP/1.0 404 Not Found', true, 404);
            die("Not Found");
        }
        $book_author = $authors->get($book['author_id']);
        self::render('book.html',[
            'book' => $book,
            'book_author' => $book_author
        ]);
    }

    public static function store($id=null)
    {
        $books = new Book();
        $authors = new Author();

        // get the id of the author or creates it
        $author = $authors->getByFullName($_POST['author']);
        if ($author){
            $author_id = $author['id'];
        }
        else{
            $author_id = $authors->insert($_POST['author']);
        }
        // insert book or updates it

        if (!$id){
            $id = $books->insert($_POST['title'], $_POST['description'], $author_id);
        }
        else
        {
            $updated = $books->update($id,$_POST['title'], $_POST['description'], $author_id);
        }

        self::flash($id?'Book saved successfully':'Book created successfully','success');

        // redirects to listing
        header("Location: /");
        die();
    }
}
