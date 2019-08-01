<?php
require $_SERVER['DOCUMENT_ROOT'] . '/livestock/config.php';

$dsn = "mysql:host=$servername;dbname=$dbname;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$db = new PDO($dsn, $username, $password, $opt);

if (!function_exists('myAutoloader')) {
    function myAutoloader($class)
    {
        $class = strtolower($class);
        $classFile = $_SERVER['DOCUMENT_ROOT'] . '/livestock/bin/' . str_replace('\\', '/', $class);

        require "$classFile.php";
    }
}
define('LOGOUT', '../logmeOut');
spl_autoload_register('myAutoloader');