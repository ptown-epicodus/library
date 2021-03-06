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

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
        }

        function getBooks()
        {
            $books = [];
            $query = $GLOBALS['DB']->query("SELECT books.* FROM authors JOIN authors_books ON (authors.id = authors_books.author_id) JOIN books ON (authors_books.book_id = books.id) WHERE authors.id = {$this->getId()};");

            foreach ($query as $book) {
                $id = $book['id'];
                $title = $book['title'];
                array_push($books, new Book($title, $id));
            }
            return $books;
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
            $GLOBALS['DB']->exec("DELETE FROM authors_books");
        }

        static function find($search_id)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM authors WHERE id = {$search_id};");
            $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Author", array("name","id"));
            $author = $query->fetch();
            return $author;
        }

        function updateProperty($property, $value)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET {$property} = '{$value}' WHERE id = {$this->getId()};");
            $this->$property = $value;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE author_id = {$this->getId()};");
        }
    }
