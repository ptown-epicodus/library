<?php
    date_default_timezone_set('America/Los_Angeles');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../src/Author.php';
    require_once __DIR__ . '/../src/Book.php';
    require_once __DIR__ . '/../src/Checkout.php';
    require_once __DIR__ . '/../src/Copy.php';
    require_once __DIR__ . '/../src/Patron.php';

    $app = new Silex\Application();

    $app['debug']=true;

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), [
        'twig.path' => __DIR__ . '/../views/'
    ]);

    $app->get("/", function() use ($app) {
        return $app['twig']->render("home.html.twig");
    });

    // Routes to CRUD books, create multiple copies of books
    $app->get("/books", function() use ($app) {
        return $app['twig']->render("books.html.twig", array('books' => Book::getAll(), 'authors' => Author::getAll()  )  );
    });

    $app->post("/books/add_author/{book_id}", function($book_id) use ($app) {
        $book = Book::find($book_id);
        $book->addAuthor(Author::find($_POST['author']));
        return $app->redirect("/books");
    });

    // Routes to CRUD authors
    $app->get("/authors", function() use ($app) {
        return $app['twig']->render("authors.html.twig");
    });

    // Routes to CRUD patrons, check out copies
    $app->get("/patrons", function() use ($app) {
        return $app['twig']->render("patrons.html.twig");
    });


    return $app;
?>
