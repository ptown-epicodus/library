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
            Author::deleteAll();
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

        function test_addAuthor()
        {
            //Arrange
            $title = 'Bible';
            $test_Book = new Book($title);
            $test_Book->save();

            $author_name = 'John Doe';
            $test_Author = new Author($author_name);
            $test_Author->save();

            //Act
            $test_Book->addAuthor($test_Author);
            $result = $test_Book->getAuthors();

            $this->assertEquals([$test_Author], $result);
        }

        function test_getAuthors()
        {
            //Arrange
            $title = 'Bible';
            $test_Book = new Book($title);
            $test_Book->save();

            $author_name1 = 'John Doe';
            $test_Author1 = new Author($author_name1);
            $test_Author1->save();

            $author_name2 = 'Jane Doe';
            $test_Author2 = new Author($author_name2);
            $test_Author2->save();

            //Act
            $test_Book->addAuthor($test_Author1);
            $test_Book->addAuthor($test_Author2);
            $result = $test_Book->getAuthors();

            $this->assertEquals([$test_Author1, $test_Author2], $result);
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
