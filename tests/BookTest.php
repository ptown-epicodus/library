<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Book.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $title = 'Bible';
            $test_Book = new Book($title);

            //Act
            $test_Book->save();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_Book], $result);
        }

        function test_getAll()
        {
            //Arrange
            $title1 = 'Bible';
            $test_Book1 = new Book($title1);
            $test_Book1->save();

            $title2 = 'Koran';
            $test_Book2 = new Book($title2);
            $test_Book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_Book1, $test_Book2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $title1 = 'Bible';
            $test_Book1 = new Book($title1);
            $test_Book1->save();

            $title2 = 'Koran';
            $test_Book2 = new Book($title2);
            $test_Book2->save();

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $title = 'Bible';
            $test_Book = new Book($title);
            $test_Book->save();
            $search_id = $test_Book->getId();

            //Act
            $result = Book::find($search_id);

            //Assert
            $this->assertEquals($test_Book, $result);
        }

        function test_updateProperty()
        {
            //Arrange
            $title = 'Bible';
            $new_title = 'Koran';
            $test_Book = new Book($title);
            $test_Book->save();

            //Act
            $test_Book->updateProperty('title', $new_title);
            $result = $test_Book->getTitle();

            //Assert
            $this->assertEquals('Koran', $result);
        }

        function test_delete()
        {
            //Arrange
            $title1 = 'Bible';
            $test_Book1 = new Book($title1);
            $test_Book1->save();

            $title2 = 'Koran';
            $test_Book2 = new Book($title2);
            $test_Book2->save();

            //Act
            $test_Book1->delete();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_Book2], $result);
        }
    }
?>
