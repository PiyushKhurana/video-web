<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$host     =  $_ENV['HOST'];  /* Host name */
$user     =  $_ENV['DBUSER'];      /* User */
$password =  $_ENV['PASSWORD'];        /* Password */
$dbname   =  $_ENV['DBNAME'];  /* Database name */

// Create connection
$con = mysqli_connect($host, $user, $password,$dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

