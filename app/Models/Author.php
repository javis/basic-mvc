<?php
namespace App\Models;
use Core\MVC\BaseModel;
use PDO;

class Author extends BaseModel
{
    public function getAll() : array
    {
        $db = $this->getDB();
        $sql = 'SELECT id, full_name FROM authors';
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
        $sql = 'SELECT id, full_name FROM authors WHERE id=:id LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute([':id'=>$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * returns only one row by full_name
     * @param  string $full_name the name of the author
     * @return array
     */
    public function getByFullName(string $full_name)
    {
        $db = $this->getDB();
        $sql = 'SELECT id, full_name FROM authors WHERE full_name=:full_name LIMIT 1';
        $query = $db->prepare($sql);
        $query->execute([':full_name'=>$full_name]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(string $full_name) : int
    {
        $db = $this->getDB();
        $sql = "INSERT INTO authors (full_name) VALUES (:full_name)";
        $query = $db->prepare($sql);
        $parameters = array(':full_name' => $full_name);
        $query->execute($parameters);
        return $db->lastInsertId();
    }
}
