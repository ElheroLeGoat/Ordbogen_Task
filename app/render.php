<?php
// Namespace and used files/projects.
namespace app;
use models;
use controllers;
require_once 'collector.php';

// Time to accommodate Axios way of handling POSTs
$_POST = json_decode(file_get_contents("php://input"),true);

$engine = new controllers\helpers\viewrender();

// $dbsess from collector.php
$user = new models\user($dbsess);

if (isset($_SESSION["userlogin"]) && isset($_GET['logout']))
{
    $user->logout();
    header("Location: /");
    die();
}

if (isset($_POST["form"]) && !isset($_SESSION["userlogin"]))
{
    if (strtolower($_POST["form"]) == 'login')
    {
        if ($user->login($_POST["username"], $_POST["password"]))
        {
            $engine->render(array("success"=> true), true );
        }
        else {
            $engine->render(array("success" => False, "reason"=>"Incorrect username or password"), true);
        }
    }
    else if (strtolower($_POST["form"]) == 'register')
    {
        $registration = $user->register($_POST["username"], $_POST["password"], $_POST["email"]);
        if ($registration["status"])
        {
            $engine->render(array("success"=> true), true );
        }
        else
        {
            if ($registration['reason'] !== null)
            {
                $engine->render(array("success" => False, "reason"=>$registration['reason']), true);
            }
            else
            {
                $errors = array();
                foreach ($registration["params"] as $key => $value)
                {
                    unset($value["status"]);       
                    foreach($value as $val)
                    {
                        $errors[] = str_replace("_string_", $key, $val);
                    }
                }
                $engine->render(array("success" => False, "reason"=>$errors), true);
            }
        }
    }
}
else 
{
    if (isset($_SESSION["userlogin"]) && $user->validate_session()) $engine->render(array("view"=>'index', "pass"=>$user));
    else $engine->render(array("view"=>'login', "pass"=>Null));
}