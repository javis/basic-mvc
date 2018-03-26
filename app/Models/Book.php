<?php
namespace App\Models;
use PDO;

class Book extends \Core\MVC\BaseModel
{
    /**
     * returns a list of all items in the table
     * @return array
     */
    public function getAll() : array
    {
        $db = $this->getDB();
        $sql = 'SELECT books.id, title, description, author_id, full_name FROM books join authors on authors.id = author_id';
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * returns only one row by id
     * @param  int $id the id of the row
     * @return array
     */
    public function get(int $id)
    {
        $db = $this->getDB();
        $sql = 'SELECT books.id, title, description, author_id, full_name FROM books join authors on authors.id = author_id WHERE books.id=:id LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute([':id'=>$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * search all books with titles like the argument
     * @param  string $title [description]
     * @return array         [description]
     */
    public function titleLike(string $title)
    {
        $db = $this->getDB();
        $sql = 'SELECT books.id, title, description, author_id , full_name FROM books join authors on authors.id = author_id  WHERE title like :title';
        $query = $db->prepare($sql);
        $query->execute([':title'=>"%$title%"]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * updates one row by id
     * @param  int     $id          [description]
     * @param  string $title       [description]
     * @param  string $description [description]
     * @param  int     $author_id   [description]
     * @return bool true if the row was updated
     */
    public function update(int $id, string $title, string $description, int $author_id) : bool
    {
        $db = $this->getDB();
        $sql = "UPDATE books SET title = :title, description = :description, author_id = :author_id WHERE id = :id";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, ':description' => $description, ':author_id' => $author_id, ':id' => $id);
        $query->execute($parameters);
        return (bool) $query->rowCount();
    }

    /**
     * creates one book and returns the new id
     * @param  string $title       [description]
     * @param  string $description [description]
     * @param  int    $author_id   [description]
     * @return int                 the id of the new row inserted
     */
    public function insert(string $title, string $description, int $author_id) : int
    {
        $db = $this->getDB();
        $sql = "INSERT INTO books (title, description, author_id) VALUES (:title, :description, :author_id)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, ':description' => $description, ':author_id' => $author_id);
        $query->execute($parameters);
        return $db->lastInsertId();
    }


    /**
     * deletes a row by id
     * @param  int    $id [description]
     * @return bool   true if the row was deleted
     */
    public function delete(int $id) : bool
    {
        $db = $this->getDB();
        $sql = "DELETE FROM books WHERE id = :id";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return (bool) $query->rowCount();
    }

}
