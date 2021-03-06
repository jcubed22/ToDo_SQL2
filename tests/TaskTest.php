<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class TaskTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Task::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $due_date = '2015-08-18';
            $test_task = new Task($description, $id, $category_id, $due_date);

            //Act
            $test_task->save();

            //Assert
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $category_id = $test_category->getId();
            $due_date = '2015-08-18';
            $test_task = new Task($description, $id, $category_id, $due_date);
            $test_task->save();
            $test_task2 = new Task($description2, $id, $category_id, $due_date);
            $test_task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $category_id = $test_category->getId();
            $due_date = '2015-08-18';
            $test_task = new Task($description, $id, $category_id, $due_date);
            $test_task->save();
            $test_task2 = new Task($description2, $id, $category_id, $due_date);
            $test_task2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $due_date = '2015-08-18';
            $test_task = new Task($description, $id, $category_id, $due_date);
            $test_task->save();

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getDate()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $due_date = '2015-08-18';
            $test_task = new Task($description, $id, $category_id, $due_date);
            $test_task->save();

            //Act
            $result = $test_task->getDate();

            //Assert
            $this->assertEquals($due_date, $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $category_id = $test_category->getId();
            $due_date = '2015-08-18';
            $test_task = new Task($description, $id, $category_id, $due_date);
            $test_task->save();
            $test_task2 = new Task($description2, $id, $category_id, $due_date);
            $test_task2->save();

            //Act
            $result = Task::find($test_task->getId());

            //Assert
            $this->assertEquals($test_task, $result);
        }

        function test_getCategoryId()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $due_date = '2015-08-18';
            $test_task = new Task($description, $id, $category_id, $due_date);
            $test_task->save();

            //Act
            $result = $test_task->getCategoryId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testGetTasks()
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $test_category_id = $test_category->getId();

            $description = "Email client";
            $due_date = '2015-08-18';
            $test_task = new Task($description, $id, $test_category_id, $due_date);
            $test_task->save();

            $description2 = "Meet with boss";
            $test_task2 = new Task($description2, $id, $test_category_id, $due_date);
            $test_task2->save();

            //Act
            $result = $test_category->getTasks();

            //Assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function testSortbyDate()
        {
            //Arrange
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $category_id = $test_category->getId();
            $due_date1 = '2015-08-18';
            $due_date2 = '2015-01-01';
            $test_task = new Task($description, $id, $category_id, $due_date1);
            $test_task->save();
            $test_task2 = new Task($description2, $id, $category_id, $due_date2);
            $test_task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_task2, $test_task], $result);
        }
    }
?>
