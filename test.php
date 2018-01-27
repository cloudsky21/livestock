<?php
use wkhtmltopdf;

$lslb = htmlentities($_GET['lslb']);

$pdf = new Pdf();

$pdf->addPage('policy.php?lslb='.$lslb);

$pdf->send();




?>