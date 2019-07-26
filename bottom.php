<?php
// Cache the contents to a file
$cached = fopen($cachefile, 'w'); // Create file fopen()
fwrite($cached, ob_get_contents());
fclose($cached);
#ob_end_flush(); // Send the output to the browser
?>