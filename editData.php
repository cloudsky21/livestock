<?php
require 'myload.php';

if (isset($_GET['code'])) {

    if ($_GET['code'] >= 0) {
        /* Code here*/

    } else {
        echo 'Invalid Data';
        echo '<script type="text/javascript">setTimeout("window.close();", 3000);</script>';
    }

} else {
    echo '<script type="text/javascript">setTimeout("window.close();", 3000);</script>';
}