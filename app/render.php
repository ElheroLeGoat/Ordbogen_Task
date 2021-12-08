<?php
// Time To figure out where we are in the system.
namespace app;
use models;
use controllers;

require_once 'collector.php';
$engine = new controllers\helpers\viewrender();
$user = new models\user($dbsess);

if (isset($_POST['login']) && !isset($_SESSION['token']))
{
    // $dbsess from Collector.php
    if ($user->login($_POST["username"], $_POST["password"]))
    {
        $engine->render('index.php');
    }
    else {
        $engine->render(array("success" => False, "reason"=>"Incorrect username or password"), true);
    }
}

if (isset($_SESSION['userlogin']) && $user->validate_session()) $engine->render('index.php');
else $engine->render('login');