<?php
namespace App\Models;
use PDO;

class Book extends \Core\MVC\BaseModel
{
    public function getAll() : array
    {
        $db = $this->getDB();
        $sql = 'SELECT id, title, description, author_id FROM books';
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) : array
    {
        $db = $this->getDB();
        $sql = 'SELECT id, title, description, author_id FROM books WHERE id=:id LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute([':id'=>$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function titleLike($title) : array
    {
        $db = $this->getDB();
        $sql = 'SELECT id, title, description, author_id FROM books WHERE title=:title';
        $query = $db->prepare($sql);
        $query->execute([':title'=>"%$title%"]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $author_id) : int
    {
        $db = $this->getDB();
        $sql = "UPDATE books SET title = :title, description = :description, author_id = :author_id WHERE id = :id";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, ':description' => $description, ':author_id' => $author_id, ':id' => $id);
        $query->execute($parameters);
        return $query->rowCount();
    }

    public function insert($title, $description, $author_id) : int
    {
        $db = $this->getDB();
        $sql = "INSERT INTO books (title, description, author_id) VALUES (:title, :description, :author_id)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, ':description' => $description, ':author_id' => $author_id);
        $query->execute($parameters);
        return $db->lastInsertId();
    }



}
