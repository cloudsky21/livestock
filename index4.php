<?PHP
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');

if(!isset($_SESSION['isLogin']) || (!isset($_COOKIE["lx"]))) { header("location: logmeOut");}

    if(isset($_COOKIE['rrrrassdawds'])){    
        $table = "control".$_COOKIE['rrrrassdawds'];    
    }
    else
    {
        header("location: logmeOut");
        exit();
    }
    if(isset($_POST['submiter'])){
        $yearNow = date("Y");   
        $getdate = date("Y-m-d", strtotime($_POST['rcv']));
        if($getdate == '1970-01-01'){
            $getdate = date("Y-m-d");
        }
        else {$getdate = date("Y-m-d", strtotime($_POST['rcv']));}
        $ids = "RO8-".date("Y")."-".date("m");
        if($_POST['animal-type']=="Carabao-Breeder" || $_POST['animal-type']=="Carabao-Draft" || $_POST['animal-type']=="Carabao-Dairy" || $_POST['animal-type']=="Carabao-Fattener"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'], -2)."-"."WB-";
        }
        else if($_POST['animal-type']=="Cattle-Breeder" || $_POST['animal-type']=="Cattle-Draft" || $_POST['animal-type']=="Cattle-Dairy" || $_POST['animal-type']=="Cattle-Fattener"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."CA-";
        }
        else if($_POST['animal-type']=="Horse-Breeder" || $_POST['animal-type']=="Horse-Draft" || $_POST['animal-type']=="Horse-Working"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."HO-";   
        }
        else if($_POST['animal-type']=="Swine-Breeder"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SB-";   
        }
        else if($_POST['animal-type']=="Swine-Fattener"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SF-";   
        }
        else if($_POST['animal-type']=="Sheep-Fattener" || $_POST['animal-type']=="Sheep-Breeder"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SH-";   
        }
        else if($_POST['animal-type']=="Poultry-Broilers"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PM-";   
        }
        else if($_POST['animal-type']=="Poultry-Layers" || $_POST['animal-type']=="Poultry-Pullets"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PE-";   
        }
        else if($_POST['animal-type']=="Goat-Breeder" || $_POST['animal-type']=="Goat-Fattener" || $_POST['animal-type'] == "Goat-Milking"){

            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."GO-";
        }
        $ids = "RO8-".date("Y")."-".date("m");
        $program = "RSBSA";

        $unwanted = array("&NTILDE;" => "Ñ");       
        $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)),$unwanted);
        $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)),$unwanted);
        $prepared = mb_strtoupper($_SESSION['isLoginName']);
        $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)),$unwanted);
        $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
        $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

        
        $barangay = strtr(mb_strtoupper(htmlentities($_POST['barangay'], ENT_QUOTES)), $unwanted);
        $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
        $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
        $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
        $prem_loading = mb_strtoupper(htmlentities($_POST['loading']), 'UTF-8');

        //check office_assignment
        if($province == "BILIRAN")
        {
            $office_assignment = "PEO Biliran";
        }
        elseif ($province == "LEYTE") {
            // Check if what district
            switch ($town) {
                case 'TACLOBAN CITY':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'ALANGALANG':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'BABATNGON':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'PALO':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'SAN MIGUEL':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'SANTA FE':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'STA. FE':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'TANAUAN':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'TOLOSA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'BARUGO':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'BURAUEN':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'CAPOOCAN':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'CARIGARA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'DAGAMI':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'DULAG':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'JARO':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'JULITA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'LA PAZ':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'PASTRANA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'TABONTABON':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'TUNGA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'CALUBIAN':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'LEYTE':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'SAN ISIDRO':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'TABANGO':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'VILLABA':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'ORMOC CITY':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'ALBUERA':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'ISABEL':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'KANANGA':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'MATAG-OB':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'MERIDA':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'PALOMPON':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'BAYBAY CITY':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'ABUYOG':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'BATO':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'HILONGOS':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'HINDANG':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'INOPACAN':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'JAVIER':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'MAHAPLAG':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'MATALOM':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;
                
            }
        }
        elseif($province == "NORTHERN SAMAR")
        {
            $office_assignment = "PEO N-Samar";
        }
        elseif($province == "WESTERN SAMAR")
        {
            $office_assignment = "PEO W-Samar";
        }
        elseif($province == "EASTERN SAMAR")
        {
            $office_assignment = "PEO E-Samar";
        }
        else
        {
            $office_assignment = "PEO Sogod";
        }

        $result = $db->prepare("INSERT INTO $table (
            Year,
            date_r,
            program,
            groupName,
            ids1,
            lsp,
            province,
            town,
            barangay,
            assured,
            farmers,
            heads,
            animal,
            premium,
            amount_cover,
            rate,
            Dfrom,
            Dto,
            status,
            office_assignment,
            loading,
            iu,
            prepared) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $result->execute([
            $yearNow,
            $getdate,
            $program,
            $group,
            $ids,
            $LSP,
            $province,
            $town,
            $barangay,
            $assured,
            $_POST['farmer-count'],
            $_POST['head-count'],
            $_POST['animal-type'],
            $bpremium,
            $_POST['cover'],
            $_POST['rate'],
            $fromDate,
            $toDate,
            "active",
            $office_assignment,
            $prem_loading,
            $iu,
            $prepared]);
        $row=$result->rowCount();
        if($row=='1'){
            unset($_POST);
            header('Location: '.$_SERVER[REQUEST_URI]); 
            exit(); 
        }
    }

    if(isset($_POST['submit_index_update'])){
// Update application form pdf
        if ($_FILES["fileUpload"]["type"] == "application/pdf" && $_FILES['fileUpload']['size'] != 0)
        {
  //do the error checking and upload if the check comes back OK
            switch ($_FILES['fileUpload'] ['error'])
            {  case 1:
                print '<p> The file is bigger than this PHP installation allows</p>';
                break;
                case 2:
                print '<p> The file is bigger than this form allows</p>';
                break;
                case 3:
                print '<p> Only part of the file was uploaded</p>';
                break;
                case 4:
                print '<p> No file was uploaded</p>';
                break;
            }

            $temp = explode(".",$_FILES['fileUpload']['name']);
            $newfilename = $_POST['ids'].'RSBSA'.'.'.end($temp);
            move_uploaded_file($_FILES["fileUpload"]["tmp_name"],
                "../L/uploads/RSBSA/".$_SESSION['insurance'].'/' . $newfilename);


            $path = "../L/uploads/RSBSA/".$_SESSION['insurance'].'/'.$newfilename;
            $result = $db->prepare("UPDATE $table SET imagepath = ? WHERE idsnumber = ?");
            $result->execute([$path,$_POST['ids']]);


        }
        else
        {
            echo "Files must be PDF or empty";
        }





        if($_POST['animal-type']=="Carabao-Breeder" || $_POST['animal-type']=="Carabao-Draft" || $_POST['animal-type']=="Carabao-Dairy" || $_POST['animal-type']=="Carabao-Fattener"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."WB-";
        }
        else if($_POST['animal-type']=="Cattle-Breeder" || $_POST['animal-type']=="Cattle-Draft" || $_POST['animal-type']=="Cattle-Dairy" || $_POST['animal-type']=="Cattle-Fattener"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."CA-";
        }
        else if($_POST['animal-type']=="Horse-Breeder" || $_POST['animal-type']=="Horse-Draft" || $_POST['animal-type']=="Horse-Working"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."HO-";   
        }
        else if($_POST['animal-type']=="Swine-Breeder"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SB-";   
        }
        else if($_POST['animal-type']=="Swine-Fattener"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SF-";   
        }
        else if($_POST['animal-type']=="Sheep-Fattener" || $_POST['animal-type']=="Sheep-Breeder"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SH-";   
        }
        else if($_POST['animal-type']=="Poultry-Broilers"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PM-";   
        }
        else if($_POST['animal-type']=="Poultry-Layers" || $_POST['animal-type']=="Poultry-Pullets"){
            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PE-";   
        }
        else if($_POST['animal-type']=="Goat-Breeder" || $_POST['animal-type']=="Goat-Fattener" || $_POST['animal-type'] == "Goat-Milking"){

            $LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."GO-";
        }


        




        $rs = $db->prepare("UPDATE $table SET 
            groupName=?, assured=?, province=?, town=?, farmers=?,heads=?,  animal=?,lsp=?, premium=?,  rate=?, amount_cover=?, Dfrom=?,
            Dto=?,  status=?, lslb=?, office_assignment = ?, loading = ?, iu=?, prepared=? WHERE idsnumber=?");

        $unwanted = array("&NTILDE;" => "Ñ");       
        $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)),$unwanted);
        $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)),$unwanted);
        $prepared = mb_strtoupper($_SESSION['isLoginName']);
        $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)),$unwanted);
        $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
        $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

        //check office_assignment
        if($province == "BILIRAN")
        {
            $office_assignment = "PEO Biliran";
        }
        elseif ($province == "LEYTE") {
            // Check if what district
            switch ($town) {
                case 'TACLOBAN CITY':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'ALANGALANG':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'BABATNGON':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'PALO':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'SAN MIGUEL':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'SANTA FE':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'STA. FE':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'TANAUAN':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'TOLOSA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'BARUGO':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'BURAUEN':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'CAPOOCAN':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'CARIGARA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'DAGAMI':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'DULAG':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'JARO':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'JULITA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'LA PAZ':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'PASTRANA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'TABONTABON':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'TUNGA':
                    # code...
                $office_assignment = "Leyte1-2";
                break;

                case 'CALUBIAN':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'LEYTE':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'SAN ISIDRO':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'TABANGO':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'VILLABA':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'ORMOC CITY':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'ALBUERA':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'ISABEL':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'KANANGA':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'MATAG-OB':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'MERIDA':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'PALOMPON':
                    # code...
                $office_assignment = "PEO Ormoc";
                break;

                case 'BAYBAY CITY':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'ABUYOG':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'BATO':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'HILONGOS':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'HINDANG':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'INOPACAN':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'JAVIER':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'MAHAPLAG':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;

                case 'MATALOM':
                    # code...
                $office_assignment = "PEO Abuyog";
                break;
                
            }
        }
        elseif($province == "NORTHERN SAMAR")
        {
            $office_assignment = "PEO N-Samar";
        }
        elseif($province == "WESTERN SAMAR")
        {
            $office_assignment = "PEO W-Samar";
        }
        elseif($province == "EASTERN SAMAR")
        {
            $office_assignment = "PEO E-Samar";
        }
        else
        {
            $office_assignment = "PEO Sogod";
        }

        $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
        $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
        $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
        $prem_loading = mb_strtoupper(htmlentities($_POST['loading']), 'UTF-8');

        $rs->execute([
            $group, 
            $assured, 
            $province, 
            $town,
            $_POST['farmer-count'], 
            $_POST['head-count'], 
            $_POST['animal-type'],
            $LSP, 
            $bpremium, 
            $_POST['rate'],
            $_POST['cover'],
            $fromDate,
            $toDate,
            $_POST['stt'],
            $_POST['lslb'],
            $office_assignment,
            $prem_loading,
            $iu,
            $prepared,
            $_POST['ids']]);    
        $row=$rs->rowCount();

        if($row > 0){
            header('location: '.$_SERVER[REQUEST_URI]);
        }



    }


    if(isset($_POST['delete_records'])){
        $del =$_POST['recorded'];
        $result = $db->prepare("DELETE FROM $table WHERE idsnumber = ?");
        $result->execute([$del]);
        $result = $db->prepare("ALTER TABLE $table AUTO_INCREMENT=1");
        $result->execute();
        header("location: ".$_SERVER[REQUEST_URI]);
    }
    ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Collapsible sidebar using Bootstrap 3</title>

         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="bootswatch/simplex/bootstrap.css">
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="css/style4.css">
    </head>
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Livestock Control</h3>
                    <strong><i class="fa fa-gears"></i></strong>
                </div>

                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="glyphicon glyphicon-home"></i>
                            Programs
                        </a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">RSBSA</a></li>
                            <li><a href="#">REGULAR</a></li>
                            <li><a href="#">APCP</a></li>
                            <li><a href="#">PUNLA</a></li>
                            <li><a href="#">AGRI-AGRA</a></li>
                            <li><a href="#">SAAD</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            About
                        </a>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="glyphicon glyphicon-duplicate"></i>
                            Pages
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li><a href="#">Page 1</a></li>
                            <li><a href="#">Page 2</a></li>
                            <li><a href="#">Page 3</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-link"></i>
                            Portfolio
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-paperclip"></i>
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-send"></i>
                            Contact
                        </a>
                    </li>
                </ul>                
            </nav>

            <!-- Page Content Holder -->
            <div id="content">

                <nav class="navbar navbar-default">
                    <div class="container-fluid">

                        <div class="navbar-header">
                            <a type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                <i class="fa fa-bars"> Toggle</i>
                            </a >
                        </div>
<!--
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>
                            </ul>
                        </div>
                    -->
                    </div>
                </nav>

               <h2>Registry System on Basic Sectors in Agriculture (RSBSA)</h2>
                <?PHP 
        $results_per_page = 10;

        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page = 1; };
        $start_from = ($page - 1) * $results_per_page;

        if($_SESSION['office']=="Regional Office") 
        {
            $rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table");
            $rs3->execute();
        }
        else
        {
            $rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table WHERE office_assignment = ?");
            $rs3->execute([$_SESSION['office']]);   
        }
        foreach($rs3 as $row){
            $getcount = $row['total'];
        }
                // calculate total pages with results
        $total_pages = ceil(round($getcount) / $results_per_page); 
        ?>
                <p>
                <div class="table-responsive">
           
                <span id="addfarmers"></span>

                <?PHP

                echo '<ul class="pagination pull-right">';

                if($page <=1){
                    echo "<li class='disabled'><a href='#'>Previous</a></li>";
                }
                else echo "<li style='cursor:pointer'><a href='index4?page=".($page-1)."'>Previous</a></li>";
                    for ($x=max($page-5, 1); $x<=max(1, min($total_pages,$page+5)); $x++)
                    {

                        if($page == $x){ echo '<li class="active"><a href="index4?page='.$x.'">'.$x.'</a></li>';} 
                        else { echo '<li><a href="index4?page='.($x).'">'.$x.'</a></li>';}
                    }
                    if($page < $total_pages){
                        echo "<li style='cursor:pointer'><a href='index4?page=".($page+1)."'>Next</a></li>";

                    }
                    else echo '<li class="disabled"><a href="#">Next</a></li>';
                    echo '</ul>';




                    ?>
                    <table class="table table-hover" id="displaydata">

                        
                        <thead>
                            <tr>
                                <th>Date Received</th>
                                <th>Livestock Policy Number</th>
                                <th>Name Of Farmers / Assured</th>

                                <th>Address</th>
                                <th>Kind of Animal</th>
                                <th>&nbsp;</th>
                            </tr>

                        </thead>
                        <tbody> 





                            <?PHP

                            if($_SESSION['office']=="Regional Office")   
                            {
                                $rs = $db->prepare("SELECT * FROM $table ORDER BY idsnumber DESC LIMIT ?, ?");
                                $rs->execute([$start_from, $results_per_page]);
                            }
                            else
                            {
                                $rs = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? ORDER BY idsnumber DESC LIMIT ?, ?");
                                $rs->execute([$_SESSION['office'], $start_from, $results_per_page]);    
                            }



                            foreach($rs as $row){

                                if ($row['status'] =="active"){
                                    echo '<tr>';
                                    echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
                                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
                                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
                    //echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
                                    echo '<td>'.$row['town'].', '.$row['province'].'</td>';
                                    echo '<td>'.$row['animal'].'</td>';

                                    if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
                                    echo '<td><a class="btn btn-default btn-xs" href="processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="glyphicon glyphicon-list"> </span></a></td>';
                                    echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-edit"/></span></a></td>';        
                                    echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';

                                    echo '</tr>';
                                }

                                else if($row['status'] =="cancelled") {
                                    echo '<tr>';
                                    echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
                                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
                                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
                    //echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
                                    echo '<td>'.$row['town'].', '.$row['province'].'</td>';
                                    echo '<td>'.$row['animal'].'</td>';
                                    if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
                                    echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-edit"/></span></a></td>';        
                                    echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';

                                    echo '</tr>';
                                }
                            }
                            ?>


                        </tbody>
                    </table>

              
               

                

               
            </div>
        </div>





        <!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
         </script>
    </body>
</html>
