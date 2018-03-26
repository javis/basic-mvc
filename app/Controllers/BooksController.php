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
        //$item = Book::findOrFail($id);
        //$item->delete();

        // show success message
        self::flash('Book removed successfully');

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
        $book = Book::with('author')->findOrFail($id);
        self::render('book.html',[
            'book' => $book
        ]);
    }

    public static function store($id=null)
    {
        $book = Book::findOrNew($id);
        $book->title = $_POST['title'];
        $book->description = $_POST['description'];
        $book->author()->associate(Author::firstOrCreate(['full_name'=>$_POST['author']]));
        $book->save();


        self::flash($id?'Book saved successfully':'Book created successfully','success');

        // redirects to listing
        header("Location: /");
        die();
    }
}
