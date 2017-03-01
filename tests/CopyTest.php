<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Copy.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Copy::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $book_id = 4;
            $test_Copy = new Copy($book_id);

            // Act
            $test_Copy->save();
            $result = Copy::getAll();

            // Assert
            $this->assertEquals([$test_Copy],$result);
        }

        function test_getAll()
        {
            //Arrange
            $book_id1 = 4;
            $test_Copy1 = new Copy($book_id1);
            $test_Copy1->save();

            $book_id2 = 5;
            $test_Copy2 = new Copy($book_id2);
            $test_Copy2->save();

            // Act
            $result = Copy::getAll();

            // Assert
            $this->assertEquals([$test_Copy1,$test_Copy2],$result);
        }


    }
?>
