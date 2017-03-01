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
    }
?>
