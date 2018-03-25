<?php

namespace App\Models;

class Book extends \Core\MVC\BaseModel
{
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT id, name FROM books');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
