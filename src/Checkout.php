<?php
    class Checkout
    {
        private $id;
        private $copy_id;
        private $patron_id;
        private $checkout_date;
        private $return_date;
        private $due_date;

        function __construct($copy_id, $patron_id, $checkout_date, $due_date, $return_date = "0000-00-00", $id = null)
        {
            $this->copy_id = $copy_id;
            $this->patron_id = $patron_id;
            $this->checkout_date = $checkout_date;
            $this->due_date = $due_date;
            $this->return_date = $return_date;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getCopyId()
        {
            return $this->copy_id;
        }
        function setCopyId($new_id)
        {
            $this->copy_id = $new_id;
        }

        function getPatronId()
        {
            return $this->patron_id;
        }
        function setPatronId($new_id)
        {
            $this->patron_id = $new_id;
        }

        function getCheckoutDate()
        {
            return $this->checkout_date;
        }
        function setCheckoutDate($new_date)
        {
            $this->checkout_date = $new_date;
        }

        function getReturnDate()
        {
            return $this->return_date;
        }
        function setReturnDate($new_date)
        {
            $this->return_date = $new_date;
        }

        function getDueDate()
        {
            return $this->due_date;
        }
        function setDueDate($new_date)
        {
            $this->due_date = $new_date;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id, checkout_date, return_date, due_date) VALUES ({$this->getCopyId()}, {$this->getPatronId()}, '{$this->getCheckoutDate()}', '{$this->getReturnDate()}', '{$this->getDueDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $checkouts = [];
            $query = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
            foreach ($query as $checkout)
            {
                $new_checkout = new Checkout($checkout['copy_id'], $checkout['patron_id'], $checkout['checkout_date'], $checkout['due_date'], $checkout['return_date'], $checkout['id']);
                array_push($checkouts, $new_checkout);
            }
            return $checkouts;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts;");
        }

        static function find($search_id)
        {
            $result = null;
            $query = $GLOBALS['DB']->query("SELECT * FROM checkouts WHERE id = {$search_id};");
            foreach ($query as $checkout)
            {
                $result = new Checkout($checkout['copy_id'], $checkout['patron_id'], $checkout['checkout_date'], $checkout['due_date'], $checkout['return_date'], $checkout['id']);
            }
            return $result;
        }
    }
?>
