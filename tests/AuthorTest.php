<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Author.php';
    require_once 'src/Book.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = 'John Doe';
            $test_Author = new Author($name);

            //Act
            $test_Author->save();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_Author], $result);
        }

        function test_getAll()
        {
            //Arrange
            $name1 = 'John Doe';
            $test_Author1 = new Author($name1);
            $test_Author1->save();

            $name2 = 'John Doe';
            $test_Author2 = new Author($name2);
            $test_Author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_Author1, $test_Author2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name1 = 'John Doe';
            $test_Author1 = new Author($name1);
            $test_Author1->save();

            $name2 = 'John Doe';
            $test_Author2 = new Author($name2);
            $test_Author2->save();

            //Act
            Author::deleteAll();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name1 = 'John Doe';
            $test_Author1 = new Author($name1);
            $test_Author1->save();

            $name2 = 'Jane Doe';
            $test_Author2 = new Author($name2);
            $test_Author2->save();

            //Act
            $search_id = $test_Author2->getId();
            $result = Author::find($search_id);

            //Assert
            $this->assertEquals($test_Author2, $result);
        }

        function test_updateProperty()
        {
            //Arrange
            $name1 = 'John Doe';
            $test_Author1 = new Author($name1);
            $test_Author1->save();

            $name2 = 'Jane Doe';
            $test_Author1->updateProperty("name",$name2);

            //Act
            $search_id = $test_Author1->getId();
            $result = Author::find($search_id);

            //Assert
            $this->assertEquals($test_Author1, $result);
        }

        function test_addBook()
        {
            //Arrange
            $author_name = 'John Doe';
            $test_Author = new Author($author_name);
            $test_Author->save();

            $book_title = 'Bible';
            $test_Book = new Book($book_title);
            $test_Book->save();

            //Act
            $test_Author->addBook($test_Book);
            $result = $test_Author->getBooks();

            //Assert
            $this->assertEquals([$test_Book], $result);
        }

        function test_getBooks()
        {
            //Arrange
            $author_name = 'John Doe';
            $test_Author = new Author($author_name);
            $test_Author->save();

            $book_title1 = 'Bible';
            $test_Book1 = new Book($book_title1);
            $test_Book1->save();

            $book_title2 = 'Koran';
            $test_Book2 = new Book($book_title2);
            $test_Book2->save();

            //Act
            $test_Author->addBook($test_Book1);
            $test_Author->addBook($test_Book2);
            $result = $test_Author->getBooks();

            //Assert
            $this->assertEquals([$test_Book1, $test_Book2], $result);
        }

        function test_delete()
        {
            //Arrange
            $name1 = 'John Doe';
            $test_Author1 = new Author($name1);
            $test_Author1->save();

            $name2 = 'Jane Doe';
            $test_Author2 = new Author($name2);
            $test_Author2->save();

            //Act
            $test_Author1->delete();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_Author2], $result);
        }
    }
?>
