<?PHP
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');
if (!isset($_SESSION['token'])) {
    header("location: logmeOut");
}


if (isset($_POST['delete_account'])) {

    $get_record = $_POST['recorded'];

    $result = $db->prepare("DELETE FROM users WHERE usrid = ?");
    $result->execute([$get_record]);

    unset($_POST);
    header("location: " . $_SERVER[REQUEST_URI]);
}

if (isset($_POST['addAccount'])) {

    //Validate if not empty

    if ((!empty($_POST['usr'])) && (!empty($_POST['pwd'])) && (!empty($_POST['sname'])) && (!empty($_POST['gname']))) {
        $userid = htmlentities($_POST['usr'], ENT_QUOTES);
        $userpas = password_hash($_POST['pwd'], PASSWORD_BCRYPT, array("cost" => 10));
        $surname = strtoupper(htmlentities($_POST['sname'], ENT_QUOTES));
        $given_name = strtoupper(htmlentities($_POST['gname'], ENT_QUOTES));
        $middlename = strtoupper(htmlentities($_POST['mname'], ENT_QUOTES));
        $userposition = htmlentities($_POST['actype'], ENT_QUOTES);
        $office_assignment = htmlentities($_POST['office']);
        $result = $db->prepare("INSERT INTO users (usrid, pswd, surname, firstname, middlename, actype, office) VALUES (?,?,?,?,?,?,?)");
        $result->execute([$userid, $userpas, $surname, $given_name, $middlename, $userposition, $office_assignment]);
        unset($_POST);
        header("location: " . $_SERVER[REQUEST_URI]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Accounts | Livestock Control</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="refresh" content="1800">
    <link rel="shortcut icon" href="images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="resources/bootswatch/solar/bootstrap.css">
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="resources/css/local.css">
    <link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
    <link rel="stylesheet" href="resources/jquery-ui-1.12.1.custom/jquery-ui.css">
    <script src="resources/bootstrap-4/js/jquery.js"></script>
    <script src="resources/bootstrap-4/umd/js/popper.js"></script>
    <script src="resources/bootstrap-4/js/bootstrap.js"></script>
    <script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
    <script type="text/javascript" src="resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  				<script type='text/javascript' src="../resources/html5shiv/src/html5shiv.js"></script>
  				<script type='text/javascript' src="../resources/Respond/src/respond.js"></script>
  			<![endif]-->

    <script>
    $(document).ready(function() {
        $('#delAccount').on('show.bs.modal', function(e) {
            var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                cache: false,
                type: 'post',
                url: 'bin/delete_account.php', //Here you will fetch records 
                data: 'rowid=' + rowid, //Pass $id
                success: function(data) {
                    $('.edit-data').html(data); //Show fetched data from database
                }
            });
        });
    });

    $(document).ready(function() {
        $('.dropdown-toggle').dropdown()
    });
    </script>
</head>

<body>
    <!-- Adding Account Modal-->
    <div class="modal fade" id="addAccount" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Add User Account</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" autocomplete="off">
                        <div class="form-group">
                            <label for="usr">User ID: </label>
                            <input type="text" class="form-control" id="usr" name="usr"
                                placeholder="Enter user account">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="pwd" name="pwd"
                                placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="sname">Surname:</label>
                            <input type="text" class="form-control" id="sname" name="sname" placeholder="Dela Cruz"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="gname">Given name:</label>
                            <input type="text" class="form-control" id="gname" name="gname" placeholder="John" required>
                        </div>
                        <div class="form-group">
                            <label for="mname">Middle name<br>(if any):</label>
                            <input type="text" class="form-control" id="mname" name="mname" placeholder="Advincula">
                        </div>
                        <div class="form-group">
                            <label for="actype">Account Type:</label>
                            <select name="actype" id="actype" class="form-control">
                                <?php
                                $result = $db->prepare("SELECT count(*) as total FROM users WHERE actype = ?");
                                $result->execute(["Admin"]);

                                foreach ($result as $row) {
                                    $abled = $row['total'];
                                    if ($abled == '2') {
                                        echo '<option value="Guest" selected>Guest</option>';
                                    } else {
                                        echo '<option value="Guest" selected>Guest</option>';
                                        echo '<option value="Admin">Admin</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="office">Office Assignment:</label>
                            <select name="office" class="form-control" id="office">
                                <option value="Leyte1-2" selected>Leyte 1 and 2</option>
                                <option value="PEO Biliran">Biliran Extension</option>
                                <option value="PEO Ormoc">Ormoc Extension</option>
                                <option value="PEO Abuyog">Abuyog Extension</option>
                                <option value="PEO Hilongos">Hilongos Extension</option>
                                <option value="PEO Sogod">Sogod Extension</option>
                                <option value="PEO W-Samar">Western Samar Extension</option>
                                <option value="PEO E-Samar">Eastern Samar Extension</option>
                                <option value="PEO N-Samar">Northern Samar Extension</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="addAccount">Add Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="delAccount" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete User Account</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="edit-data"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="delete_account" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <!-- Brand -->
        <div class="container">
            <a class="navbar-brand mx-auto" href="home">
                <h3>Livestock</h3>
                <p style="margin-top:-10px; margin-bottom: 0px; font: 12px Open Sans; color: #aaa; text-shadow: none;">
                    Control / Policy Issuance</p>
            </a>
            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link btn btn-sm btn-warning" href="#" data-toggle="modal"
                            data-target="#addAccount" data-backdrop="static" data-keyboard="false">New Account </a></li>
                    &nbsp; &nbsp;
                    <li class="nav-item">
                        <a class="nav-link" href="logmeOut"><i class="fa fa-sign-out"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="home">Livestock Control</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" data-toggle="modal" data-target="#addAccount"><span class="fa fa-plus"></span></a></li>
                <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                            class="fa fa-user"></span>&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" style="color:gray; pointer-events: none; border-bottom: 1px solid #ddd"
                                tabindex="-1">
                                <?PHP echo $_SESSION['isLoginName']; ?></a></li>
                        <li><a href="year">Insurance Year</a></li>
                        <li><a href="locations">Locations</a></li>
                        <li><a href="farmers">Farmers List</a></li>
                        <li><a href="accounts">Accounts</a></li>
                        <li><a href="logmeOut">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div style="margin-top:100px;">
            <table class="table table-condensed table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Account ID</th>
                        <th>Password (Encrypted)</th>
                        <th>Account Name</th>
                        <th>Account Type</th>
                        <th></th>
                    </tr>
                </thead>

                <?PHP
                # Perform database query
                $query = "SELECT * FROM `users` WHERE usrid != ? ORDER BY `usrid` ASC";
                $result = $db->prepare($query);
                $result->execute(["root"]);
                foreach ($result as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['usrid'] . '</td>';
                    echo '<td>' . $row['pswd'] . '</td>';
                    echo '<td>' . $row['firstname'] . "\n" . $row['surname'] . '</td>';
                    echo '<td>' . $row['actype'] . '</td>';
                    echo '<td><button type="submit" class="btn btn-outline-danger btn-sm" name="btn_delete" data-id="' . $row['usrid'] . '" data-toggle="modal" data-target="#delAccount"><span class="fa fa-trash-o"></span></button>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>