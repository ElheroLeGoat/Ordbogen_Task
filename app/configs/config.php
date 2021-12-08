<?php


/**
 * Database information
 * 
 * This associative array contains needed information to connect to a dataase.
 * 
 * @important: Username and password should only be simple in a local testing env.
 * 
 * @var array $dbi
 */
$dbi = ['host'=>'localhost',
        'port'=>'3306',
        'scheme'=> 'ordbogen',
        'username'=>'root',
        'passwrd'=>''];

/**
 * Debug setting
 * 
 * This setting allows Debug to be disabled on the production server and enabled on the maintenance server.
 * 
 * @var boolean $debug
 */
$debug = True;