<?php
session_start();
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\html;

$html = new html();
$css = [
    './resources/bootswatch/' . $_SESSION['mode'] . '/bootstrap.css',
    './resources/css/font-awesome/css/font-awesome.css',
    './resources/css/local.css?v=' . filemtime('./resources/css/local.css') . '',

];
$html->pageTitle("RSBSA | Livestock Control");
$html->styleSheet($css);
$html->output();