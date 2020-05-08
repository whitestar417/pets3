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

//Define a default route
$f3->route('GET /', function()
{
    $view = new Template();
    echo $view->render('views/pet-home.html');
});

//Define an order route
$f3->route('GET|POST /order', function($f3)
{
    //Check if the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //Validate the data
        if (empty($_POST['pet']))
        {
            //Data is invalid
            echo 'Please supply a pet type';
        }
        else
        {
            //Data is valid
            $_SESSION['pet'] = $_POST['pet'];

            //Add color to the session
            $_SESSION['color'] = $_POST['color'];

            //Redirect to the summary route
            $f3->reroute("summary");
        }
    }

    $view = new Template();
    echo $view->render('views/pet-order.html');
});

//Summary route
$f3->route('GET /summary', function() {
    //echo '<h1>Welcome to my summary</h1>';

    $view = new Template();
    echo $view->render('views/order-summary.html');

});

//Run fat free
$f3->run();