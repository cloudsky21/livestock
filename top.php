<?php
$url = $_SERVER["REQUEST_URI"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
if(!file_exists($_SESSION['isLoginID'])) {
    mkdir($_SESSION['isLoginID'],0777);
}
$cachefile = $_SESSION['isLoginID'].'/cached-'.substr_replace($file ,"",-4).'.php';
$cachetime = 10000;

// Serve from the cache if it is younger than $cachetime

if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
    include($cachefile);
    exit;
}
file_get_contents($url);

//ob_start(); // Start the output buffer
?>