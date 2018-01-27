 <?php
 //DB details
        $servername     = 'localhost';
        $username = 'root';
        $password = 'pinipirawako';
        $dbname     = 'test';
        $charset = 'utf8';

        $dsn = "mysql:host=$servername;dbname=$dbname;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $db = new PDO($dsn, $username, $password, $opt);
    ?>