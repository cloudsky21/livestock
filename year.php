<?PHP
session_start();
require_once "connection/conn.php";
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['token'])) {header("location: ../logmeOut");}

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db->beginTransaction();
    try {
        $pyear = htmlentities($_POST['year']);
        $tablename = 'rsbsa' . $pyear;
        $tb_reg = "regular" . $pyear;
        $tb_apcp = "apcp" . $pyear;
        $tb_pnl = "punla" . $pyear;
        $tbl_agri = 'agriagra' . $pyear;
        $tbl_saad = 'saad' . $pyear;
        $tbl_yrrp = 'yrrp' . $pyear;

        $result = $db->prepare("INSERT INTO year(year) VALUES(?)");
        $result->execute([$pyear]);

//RSBSA
        $result = $db->prepare("
				CREATE TABLE `$tablename` (
				Year INT(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(300) NOT NULL,
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				f_id DECIMAL(20,0) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal VARCHAR(300) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,2) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				loading VARCHAR(500) NOT NULL,
				iu VARCHAR(200) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				tag VARCHAR(200) NOT NULL,
				date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (idsnumber)
			);");

        $result->execute();
//AGRI-AGRA
        $result = $db->prepare("
				CREATE TABLE `$tbl_agri` (
				Year INT(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(300) NOT NULL,
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				f_id DECIMAL(20,0) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal VARCHAR(300) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,2) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				loading VARCHAR(500) NOT NULL,
				iu VARCHAR(200) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				tag VARCHAR(200) NOT NULL,
				date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (idsnumber)
			);");

        $result->execute();
//SAAD
        $result = $db->prepare("
				CREATE TABLE `$tbl_saad` (
				Year INT(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(4) NOT NULL DEFAULT 'SAAD',
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				f_id DECIMAL(20,0) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal VARCHAR(300) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,2) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				loading VARCHAR(500) NOT NULL,
				iu VARCHAR(200) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				tag VARCHAR(200) NOT NULL,
				date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (idsnumber)
			);");

        $result->execute();

//YRRP
        $result = $db->prepare("
				CREATE TABLE `$tbl_yrrp` (
				Year INT(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(4) NOT NULL DEFAULT 'YRRP',
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				f_id DECIMAL(20,0) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal VARCHAR(300) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,2) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				loading VARCHAR(500) NOT NULL,
				iu VARCHAR(200) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				tag VARCHAR(200) NOT NULL,
				date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (idsnumber)
			);");

        $result->execute();

//REGULAR

        $result = $db->prepare("
				CREATE TABLE `$tb_reg` (
				Year INT(4) NOT NULL,
				date_r DATE NOT NULL,
				receiptNumber DECIMAL(20,0) NOT NULL,
				receiptAmt DECIMAL(20,2) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				rcd VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				f_id DECIMAL(20,0) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal VARCHAR(300) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,2) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				second_from DATE NOT NULL,
				second_to DATE NOT NULL,
				third_from DATE NOT NULL,
				third_to DATE NOT NULL,
				imagepath VARCHAR(300) NOT NULL,
				loading VARCHAR(500) NOT NULL,
				iu VARCHAR(500) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				s_charge DECIMAL(20,2) NOT NULL,
				tag VARCHAR(200) NOT NULL,
				date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (idsnumber)
			);");

        $result->execute();

        //APCP
        $result = $db->prepare("
				CREATE TABLE `$tb_apcp` (
				Year INT(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(4) NOT NULL DEFAULT 'APCP',
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				f_id DECIMAL(20,0) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal VARCHAR(300) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,2) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				iu VARCHAR(200) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				tag VARCHAR(200) NOT NULL,
				date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (idsnumber)
			);");

        $result->execute();

        //PUNLA
        $result = $db->prepare("
				CREATE TABLE `$tb_pnl` (
				Year INT(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(4) NOT NULL DEFAULT 'PNL',
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				f_id DECIMAL(20,0) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal VARCHAR(300) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,2) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				loading VARCHAR(500) NOT NULL,
				iu VARCHAR(200) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				tag VARCHAR(200) NOT NULL,
				date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (idsnumber)
			);");

        $result->execute();

        $RSBSA = "../L/uploads/RSBSA/" . $pyear;
        if (!file_exists($RSBSA)) {
            mkdir($RSBSA, 0777, true);
        }
        $AGRIAGRA = "../L/uploads/AGRIAGRA/" . $pyear;
        if (!file_exists($AGRIAGRA)) {
            mkdir($AGRIAGRA, 0777, true);
        }
        $REG = "../L/uploads/REGULAR/" . $pyear;
        if (!file_exists($REG)) {
            mkdir($REG, 0777, true);
        }
        $APCP = "../L/uploads/APCP/" . $pyear;
        if (!file_exists($APCP)) {
            mkdir($APCP, 0777, true);
        }
        $PNL = "../L/uploads/ACPC/" . $pyear;
        if (!file_exists($PNL)) {
            mkdir($PNL, 0777, true);
        }
        $SAAD = "../L/uploads/SAAD/" . $pyear;
        if (!file_exists($SAAD)) {
            mkdir($SAAD, 0777, true);
        }
        $YRRP = "../L/uploads/YRRP/" . $pyear;
        if (!file_exists($YRRP)) {
            mkdir($YRRP, 0777, true);
        }

        //    $f_keys_alter = array($tb_reg, $tb_apcp, $tb_pnl, $tbl_agri, $tbl_saad, $tbl_yrrp);

        $query = $db->prepare("ALTER TABLE $tb_reg ADD FOREIGN KEY (`Year`) REFERENCES `year`(`yearid`) ON DELETE RESTRICT ON UPDATE RESTRICT");
        $query->execute();

        $query = $db->prepare("ALTER TABLE $tb_apcp ADD FOREIGN KEY (`Year`) REFERENCES `year`(`yearid`) ON DELETE RESTRICT ON UPDATE RESTRICT");
        $query->execute();

        $query = $db->prepare("ALTER TABLE $tb_pnl ADD FOREIGN KEY (`Year`) REFERENCES `year`(`yearid`) ON DELETE RESTRICT ON UPDATE RESTRICT");
        $query->execute();

        $query = $db->prepare("ALTER TABLE $tbl_agri ADD FOREIGN KEY (`Year`) REFERENCES `year`(`yearid`) ON DELETE RESTRICT ON UPDATE RESTRICT");
        $query->execute();

        $query = $db->prepare("ALTER TABLE $tbl_saad ADD FOREIGN KEY (`Year`) REFERENCES `year`(`yearid`) ON DELETE RESTRICT ON UPDATE RESTRICT");
        $query->execute();

        $query = $db->prepare("ALTER TABLE $tbl_yrrp ADD FOREIGN KEY (`Year`) REFERENCES `year`(`yearid`) ON DELETE RESTRICT ON UPDATE RESTRICT");
        $query->execute();

        //unset($_POST);
        //header('Location: '.$_SERVER[REQUEST_URI]);

    } catch (Exception $e) {
        echo $e->getMessage();
        $db->rollback();
    }

}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Livestock | Control</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="resources/bootswatch/solar/bootstrap.css">
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="resources/css/local.css">
    <link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
    <script src="resources/bootstrap-4/js/jquery.js"></script>
    <script src="resources/bootstrap-4/umd/js/popper.js"></script>
    <script src="resources/bootstrap-4/js/bootstrap.js"></script>
    <script type="text/javascript" src="resources/multi-select/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <!-- Brand -->
            <div class="container">
                <a class="navbar-brand" href="home">
                    Livestock Control</a>

                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">

                    <ul class="navbar-nav ml-auto">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" id="navbardrop"
                                data-toggle="dropdown">
                                Programs
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="programs/rsbsa">RSBSA</a>
                                <a class="dropdown-item" href="programs/regular">Regular Program</a>
                                <a class="dropdown-item" href="programs/apcp">APCP</a>
                                <a class="dropdown-item" href="programs/acpc">Punla</a>
                                <a class="dropdown-item" href="programs/agriagra">AGRI-AGRA</a>
                                <a class="dropdown-item" href="programs/saad">SAAD</a>
                                <a class="dropdown-item" href="programs/yrrp">YRRP</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" data-toggle="dropdown">
                                <span class="fa fa-gears"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <?php
echo '<a class="dropdown-item disabled" href="#">' . $_SESSION['isLoginName'] . '</a>';
echo '<div class="dropdown-divider"></div>';
if ($_SESSION['stat'] == "Main") { ?>
                                <a class="dropdown-item" href="year">Insurance Year</a>

                                <a class="dropdown-item" href="farmers">Farmers List</a>
                                <a class="dropdown-item" href="accounts">Accounts</a>
                                <?php
}
?>
                                <a class="dropdown-item" href="comments">Comments</a>
                                <a class="dropdown-item" href="locations">Locations</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logmeOut"><i class="fa fa-sign-out"
                                    style="font-size:20px"></i></a></li>
                    </ul>



                </div>
            </div>
        </nav>

        <div style="margin-top:100px;">
            <form method="post" class="form-inline" action="">
                <div class="form-group">
                    <label for="year">Year:</label>

                    <input type="number" name="year" step="any" min="0" class="form-control input-lg">

                </div>
                <button type="submit" class="btn btn-primary">Add Year</button>
        </div>
        </form>


        <table class="table table-bordered table-condensed table-striped" style="margin-top: 100px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Year</th>

                </tr>
            </thead>

            <tbody>
                <?php
$result = $db->prepare("SELECT * FROM year");
$result->execute();

foreach ($result as $row) {
    echo '<tr>';
    echo '<td>' . $row['yearid'] . '</td>';
    echo '<td>' . $row['year'] . '</td>';
    echo '</tr>';

}
?>

            </tbody>


        </table>
    </div>











    </div>
</body>

</html>