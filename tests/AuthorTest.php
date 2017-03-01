<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Author.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
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
    }
?>
