<?php

namespace app;

require_once __DIR__ . "/configs/definitions.php";


// config from app\configs\definitions.php
require_once CONFIG . "config.php";

// Class autoloader
spl_autoload_register(function ($class_name) {
    require_once $class_name . '.php';
});

// General database connection. $dbi from config.php
$dbsess = new \mysqli($dbi['host'], $dbi['username'], $dbi['passwrd'], $dbi['scheme']);

if ($dbsess->connect_errno && $debug)
{
    echo "Failed to Connect to the database" . $mysqli->connect_error;
}