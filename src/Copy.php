<?php
    class Copy
    {
        private $id;
        private $book_id;

        function __construct($book_id, $id = null)
        {
            $this->book_id = $book_id;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }
        function getBookId()
        {
            return $this->book_id;
        }

        function setBookId($new_book_id)
        {
            $this->book_id = $new_book_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ({$this->book_id});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Copy", ['book_id','id']);
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies;");
        }

        static function find($search_id)
        {
                $query = $GLOBALS['DB']->query("SELECT * FROM copies WHERE id = {$search_id};");
            $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Copy', [
                'book_id',
                'id'
            ]);
            return $query->fetch();
        }
    }
?>
