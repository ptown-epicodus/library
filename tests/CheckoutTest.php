<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Checkout.php';
    require_once 'src/Book.php';
    require_once 'src/Copy.php';
    require_once 'src/Patron.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Checkout::deleteAll();
            Book::deleteAll();
            Patron::deleteAll();
            Copy::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $title = 'Bible';
            $test_Book = new Book($title);
            $test_Book->save();
            $book_id = $test_Book->getId();

            $test_copy = new Copy($book_id);
            $test_copy->save();

            $name = 'Jim';
            $test_patron = new Patron($name);
            $test_patron->save();

            $copy_id= $test_copy->getId();
            $patron_id= $test_patron->getId();
            $checkout_date = "2017-02-02";
            $due_date = "2017-02-02";
            $test_Checkout = new Checkout($copy_id, $patron_id, $checkout_date, $due_date);

            // Act
            $test_Checkout->save();
            $result = Checkout::getAll();

            // Assert
            $this->assertEquals([$test_Checkout],$result);
        }

        function test_getAll()
        {
            //Arrange
            $title = 'Bible';
            $test_Book = new Book($title);
            $test_Book->save();
            $book_id = $test_Book->getId();

            $test_copy = new Copy($book_id);
            $test_copy->save();

            $name = 'Jim';
            $test_patron = new Patron($name);
            $test_patron->save();

            $copy_id= $test_copy->getId();
            $patron_id= $test_patron->getId();
            $checkout_date = "2017-02-02";
            $due_date = "2017-02-02";
            $test_Checkout = new Checkout($copy_id, $patron_id, $checkout_date, $due_date);
            $test_Checkout->save();

            $checkout_date2 = "2017-03-03";
            $due_date2 = "2017-03-14";
            $test_Checkout2 = new Checkout($copy_id, $patron_id, $checkout_date2, $due_date2);
            $test_Checkout2->save();

            // Act
            $result = Checkout::getAll();

            // Assert
            $this->assertEquals([$test_Checkout, $test_Checkout2],$result);
        }

        function test_find()
        {
            //Arrange
            $title = 'Bible';
            $test_Book = new Book($title);
            $test_Book->save();
            $book_id = $test_Book->getId();

            $test_copy = new Copy($book_id);
            $test_copy->save();

            $name = 'Jim';
            $test_patron = new Patron($name);
            $test_patron->save();

            $copy_id= $test_copy->getId();
            $patron_id= $test_patron->getId();
            $checkout_date = "2017-02-02";
            $due_date = "2017-02-02";
            $test_Checkout = new Checkout($copy_id, $patron_id, $checkout_date, $due_date);
            $test_Checkout->save();

            $checkout_date2 = "2017-03-03";
            $due_date2 = "2017-03-14";
            $test_Checkout2 = new Checkout($copy_id, $patron_id, $checkout_date2, $due_date2);
            $test_Checkout2->save();

            // Act
            $result = Checkout::find($test_Checkout2->getId());

            // Assert
            $this->assertEquals($test_Checkout2, $result);
        }
    }
?>
