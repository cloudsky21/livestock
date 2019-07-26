<?php
session_start();
require_once "connection/conn.php";
require 'myload.php';

use Classes\token;

date_default_timezone_set('Asia/Manila');

$token = new token();

$token->destroyToken($db,$_SESSION['isLoginID']);


session_destroy();
header("location: index");


?>