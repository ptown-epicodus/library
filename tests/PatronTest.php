<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Patron.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $title = 'Bible';
            $test_Patron = new Patron($title);

            //Act
            $test_Patron->save();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_Patron], $result);
        }

        function test_getAll()
        {
            //Arrange
            $title1 = 'Bible';
            $test_Patron1 = new Patron($title1);
            $test_Patron1->save();

            $title2 = 'Koran';
            $test_Patron2 = new Patron($title2);
            $test_Patron2->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_Patron1, $test_Patron2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $title1 = 'Bible';
            $test_Patron1 = new Patron($title1);
            $test_Patron1->save();

            $title2 = 'Koran';
            $test_Patron2 = new Patron($title2);
            $test_Patron2->save();

            //Act
            Patron::deleteAll();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name1 = 'John Doe';
            $test_Patron1 = new Patron($name1);
            $test_Patron1->save();

            $name2 = 'Jane Doe';
            $test_Patron2 = new Patron($name2);
            $test_Patron2->save();

            //Act
            $search_id = $test_Patron2->getId();
            $result = Patron::find($search_id);

            //Assert
            $this->assertEquals($test_Patron2, $result);
        }

        function test_updateProperty()
        {
            //Arrange
            $name1 = 'John Doe';
            $test_Patron1 = new Patron($name1);
            $test_Patron1->save();

            $name2 = 'Jane Doe';
            $test_Patron1->updateProperty("name",$name2);

            //Act
            $search_id = $test_Patron1->getId();
            $result = Patron::find($search_id);

            //Assert
            $this->assertEquals($test_Patron1, $result);
        }

        function test_delete()
        {
            //Arrange
            $name1 = 'John Doe';
            $test_Patron1 = new Patron($name1);
            $test_Patron1->save();

            $name2 = 'John Doe';
            $test_Patron2 = new Patron($name2);
            $test_Patron2->save();

            //Act
            $test_Patron1->delete();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_Patron2], $result);
        }


    }
?>
