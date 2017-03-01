<?php
    class Book
    {
        private $id;
        private $title;

        function __construct($title, $id = null)
        {
            $this->id = $id;
            $this->title = $title;
        }

        function getId()
        {
            return $this->id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function updateProperty($property, $value)
        {
            $GLOBALS['DB']->exec("UPDATE books SET {$property} = '{$value}' WHERE id = {$this->getId()};");
            $this->$property = $value;
        }

        static function getAll()
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Book', [
                'title',
                'id'
            ]);
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        static function find($search_id)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$search_id};");
            $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Book', [
                'title',
                'id'
            ]);
            $book = $query->fetch();
            return $book;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }
    }
?>
