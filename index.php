<?PHP
session_start();
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\token;

$token = new token();
$get_result = "";

?>
<?php

if (isset($_SESSION['token'])) {

    /*fetch token*/
    $fetchedToken = $_SESSION['token'];

    /*fetch db details*/
    $result = $db->prepare("SELECT * FROM users WHERE token = ? LIMIT 1");
    $result->execute([$fetchedToken]);

    if ($result->rowCount() > 0) {
        foreach ($result as $row) {

            $name_account = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['surname'];
            $id = $row['usrid'];
            $stat = $row['actype'];
            $officeDes = $row['office'];
            $_SESSION['mode'] = $row['mode'];

            $_SESSION['office'] = $officeDes;
            $_SESSION['isLogin'] = 1;
            $_SESSION['isLoginID'] = $id;
            $_SESSION['stat'] = $stat;
            $_SESSION['isLoginName'] = $name_account;
            $_SESSION['xValue'] = $id;
            $_SESSION['pValue'] = $row['pswd'];
            $_SESSION['insurance'] = $row['y_chosen'];

            # generate token
            $generated_token = $token->generateToken($id);
            $token->insertToken($db, $generated_token, $id, $_SESSION['insurance']);
            $_SESSION['token'] = $generated_token;
            header("location: home");
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /*Converts to Code*/
    $userid = htmlentities($_POST['name'], ENT_QUOTES);

    /*Encrypts Password*/
    $userpas = sha1($_POST['password']);

    /*Checks if Year is not null*/

    if (!empty($_POST['i_year'])) {
        $getYear = $db->prepare("SELECT yearid, year FROM year WHERE yearid = ?");
        $getYear->execute([$_POST['i_year']]);

        foreach ($getYear as $row) {
            $_SESSION['insurance'] = $row['year'];
            $_SESSION['insuranceCode'] = $row['yearid'];
        }
    }

    /*Checks username and password in database*/
    $result = $db->prepare("SELECT * FROM users WHERE usrid = ? LIMIT 1");
    $result->execute([$userid]);

    if ($result->rowcount() > 0) {

        foreach ($result as $row) {

            if (password_verify($_POST['password'], $row['pswd'])) {

                $name_account = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['surname'];
                $id = $row['usrid'];
                $stat = $row['actype'];
                $officeDes = $row['office'];

                $_SESSION['office'] = $officeDes;
                $_SESSION['isLogin'] = 1;
                $_SESSION['isLoginID'] = $id;
                $_SESSION['stat'] = $stat;
                $_SESSION['isLoginName'] = $name_account;
                $_SESSION['mode'] = $_POST['mode'];

                # generate token
                $token->_mode($_POST['mode'], $id);
                $generated_token = $token->generateToken($id);
                $token->insertToken($db, $generated_token, $id, $_SESSION['insurance']);
                $_SESSION['token'] = $generated_token;
                header("location: home");
            }
        }
    } else {

        $get_result = '<div id="flash-msg" class="alert alert-danger">Account Not Found!!!</div>';        
        unset($_POST);
    }

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livestock | Control System</title>
    <link rel="shortcut icon" href="images/favicon.ico" />

    <link rel="stylesheet" href="resources/bootswatch/cyborg/bootstrap.css">
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="resources/css/local.css?v=<?=filemtime('resources/css/local.css')?>" type="text/css">

    <link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
    <script src="resources/bootstrap-4/js/jquery.js"></script>
    <script src="resources/bootstrap-4/umd/js/popper.js"></script>
    <script src="resources/bootstrap-4/js/bootstrap.js"></script>
    <script>
    $(document).ready(function() {
        $("#flash-msg").delay(3000).fadeOut("slow");
    });
    </script>
</head>


<body>
    <div class="container">
        <div class="login col-centered">
            <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $get_result;
}?>

            <form action="" Method="POST" role="form">
                <div class="form-group">
                    <label for="usr">Username:</label>
                    <input type="text" class="form-control" id="usr" name="name" required placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" id="pwd" name="password" class="form-control" required
                        placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="i_year">Year:</label>
                    <select id="i_year" name="i_year" class="form-control">
                        <?php
$sql = "SELECT * FROM livestock.year order by yearid ASC;";
$result = $db->prepare($sql);
$result->execute();
foreach ($result as $row) {
    echo '<option value="' . $row['yearid'] . '" selected="selected">' . $row['year'] . '</option>';
}
?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mode">Mode:</label>
                    <select name="mode" class="form-control">
                        <option value="solar">Night</option>
                        <option value="lumen">Light</option>
                        <option value="slate">Dark</option>
                        <option value="pulse">Default</option>
                        <option value="cyborg">Cyborg</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-secondary btn-large form-control" name="letmein">Let me
                    in.</button>
            </form>
        </div>
    </div>
</body>

</html>