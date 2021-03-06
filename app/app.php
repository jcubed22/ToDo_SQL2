<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

    //session_start();
    //if (empty($_SESSION['list_of_tasks'])) {
    //    $_SESSION['list_of_tasks'] = array();
    //}

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('categories' => Category::getAll()));
    });

    $app->get("/categories/{id}", function($id) use ($app){
        $timezone_identifier = 'America/Los_Angeles';
        date_default_timezone_set ($timezone_identifier);
        $category = Category::find($id);
        return $app['twig']->render('category.html.twig', array('category' => $category, 'tasks' => $category->getTasks()));
    });

    $app->post("/tasks", function() use ($app) {

        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $timezone_identifier = 'America/Los_Angeles';
        date_default_timezone_set ($timezone_identifier);
        $due_date = $_POST['due_date'];
        $task = new Task($description, $id=null, $category_id, $due_date);
        $task->save();
        $category = Category::find($category_id);
        return $app['twig']->render('category.html.twig', array('category' => $category, 'tasks' => $category->getTasks()));
    });

    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('index.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        Task::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_tasks", function() use ($app) {

        Task::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
 ?>
