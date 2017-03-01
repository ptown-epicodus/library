<?php
    class Author
    {
        private $id;
        private $name;

        function __construct($name, $id = null)
        {
            $this->id = $id;
            $this->name = $name;
        }

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $queries = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = $queries->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Author" , array("name","id"));
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");

        }

        static function find($search_id)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM authors WHERE id= {$search_id};");
            $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Author", array("name","id"));
            $author = $query->fetch();
            return $author;
        }
    }
