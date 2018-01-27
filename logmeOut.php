<?php
session_start();
date_default_timezone_set('Asia/Manila');


if(isset($_COOKIE['lx']))
{

	

setcookie("lx"," ", time() - 172800);
setcookie("lp"," ", time() - 172800);
setcookie("rrrrassdawds"," ", time() - 172800);

}

session_destroy();
header("location: index");


?>