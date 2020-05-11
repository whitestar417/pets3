<?php
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');

//Instantiate the F3 Base class
$f3 = Base::instance();   //a Fat Free object

$f3->set('colors', array('pink', 'green', 'blue'));

//Require the validation file
require_once('models/validation-functions.php');

//Define a default route
$f3->route('GET /', function()
{
    $view = new Template();
    echo $view->render('views/pet-home.html');
});

//Define an order route
$f3->route('GET|POST /order', function($f3)
{
    //Clear SESSION variable
    $_SESSION = array();

    //Check if the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        $pet = $_POST['pet'];

        //Validate the data
        if (validString($pet))
        {
            $_SESSION['pet'] = $pet;

            //Redirect to the summary route
            $f3->reroute("order2");

        }
        else
        {
            //Data is invalid
            $f3->set("errors['pet']", "Please enter an animal.");


        }
    }

    $view = new Template();
    echo $view->render('views/pet-order.html');
});

//Define an order route
$f3->route('GET|POST /order2', function($f3)
{
    //Check if the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        $color = $_POST['color'];

        //Validate the data
        if (validColor($color))
        {
            //Add color to the session
            $_SESSION['color'] = $_POST['color'];

            //Redirect to the summary route
            $f3->reroute("summary");
        }
        else
        {
            //Data is invalid
            $f3->set("errors['color']", "Please enter a valid color.");
        }
    }

    $view = new Template();
    echo $view->render('views/pet-order2.html');
});

//Summary route
$f3->route('GET /summary', function() {
    //echo '<h1>Welcome to my summary</h1>';

    $view = new Template();
    echo $view->render('views/order-summary.html');

});

//Run fat free
$f3->run();