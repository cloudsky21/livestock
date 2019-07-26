<?PHP
session_start();
require_once("connection/conn.php");
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();

$table = $obj->list();

?>
<!DOCTYPE html>
<html>
<head>
 <title>RSBSA MASTERLIST | Livestock Control</title>	
 <meta http-equiv="content-type" content="text/html; charset=UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
 <meta http-equiv="refresh" content="180">
 <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
 <!--[if IE]><link rel="shortcut icon" href="../images/favicon-32x32.ico" ><![endif]-->
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css">
 <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
 <link rel="stylesheet" href="resources/css/local.css">
 <link rel="stylesheet" href="resources/css/animate.css">
 <link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
 <link rel="stylesheet" href="resources/jquery-ui-1.12.1.custom/jquery-ui.css">
 <script src="resources/bootstrap-4/js/jquery.js"></script>
 <script src="resources/bootstrap-4/umd/js/popper.js"></script>
 <script src="resources/bootstrap-4/js/bootstrap.js"></script>
 <script type ="text/javascript" src="resources/js/rsbsa.js"></script>
 <script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
 <script type="text/javascript" src="resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
 <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
    	<script type='text/javascript' src="resources/html5shiv/src/html5shiv.js"></script>
  		<script type='text/javascript' src="resources/Respond/src/respond.js"></script>
  	<![endif]-->
  	<script type="text/javascript" src="resources/multi-select/bootstrap-multiselect.js"></script>  	
    <script type="text/javascript">
     $(document).ready(function(){
      $("#displaydata tr").dblclick(function () {
        if($(this).hasClass('table-active')) {
          $(this).removeClass('table-active');
        }
        else {
          $(this).addClass('table-active');  
        }          
      });
    });   
  </script>
</head>
<body>
  <?php switch ($_SESSION['mode']) {
    case 'solar':       
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
    break;

    case 'sandstone':
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="top">';
    break;      
  }
  ?>
  <div class="container">
   <a class="navbar-brand mx-auto" href="home">
    <h3>Livestock</h3>
    <p style="margin-top:-10px; margin-bottom: 0px; font: 12px Open Sans; color: #aaa; text-shadow: none;">Control / Policy Issuance</p>
  </a>
  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">
          <button class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Add Farmer</button>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          <span class="fa fa-navicon"></span> Programs
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="rsbsa">RSBSA</a>
          <a class="dropdown-item" href="regular">Regular Program</a>
          <a class="dropdown-item" href="apcp">APCP</a>
          <a class="dropdown-item" href="acpc">Punla</a>
          <a class="dropdown-item" href="agriagra">AGRI-AGRA</a>
          <a class="dropdown-item" href="saad">SAAD</a>
          <a class="dropdown-item" href="yrrp">YRRP</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
          <span class="fa fa-gears"></span> Settings 
        </a>
        <div class="dropdown-menu">
          <?php 
          if($_SESSION['stat']=="Main") 
          { 
            ?>
            <a class="dropdown-item" href="year">Insurance Year</a>
            <a class="dropdown-item" href="farmers">Farmers List</a>
            <a class="dropdown-item" href="accounts">Accounts</a>
            <a class="dropdown-item" href="masterlist">RSBSA List</a>
            <a class="dropdown-item" href="checkbox" target="_blank">Checklist</a>
            <a class="dropdown-item" href="extract" target="_blank">Extract Reports</a>
            <?php 
          }
          ?>
          <a class="dropdown-item" href="comments">Comments</a>
          <a class="dropdown-item" href="locations">Locations</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logmeOut">
          <i class="fa fa-sign-out" style="font-size:15px"></i>
        </a>
      </li>  
    </ul>    
  </div>
</div>
</nav> 

<div class="container-fluid">
 <div class="jumbotron" style="margin-top: 50px">
  <h2 class="display-5">Registry System on Basic Sectors in Agriculture (RSBSA)</h2>
  <p class="lead">Search Farmers listed on RSBSA.</p>
  
  <hr>
</div>
<?PHP /* ============== RESULTS DISPLAYED PER PAGE ==========  */
$results_per_page = 25;
/* =======================================================*/
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page = 1; };
$start_from = ($page - 1) * $results_per_page;

$rs3 = $db->prepare("SELECT COUNT(*) AS total FROM $table");
$rs3->execute();

foreach($rs3 as $row){
  $getcount = $row['total'];
}
				// calculate total pages with results
$total_pages = ceil(round($getcount) / $results_per_page); 
?>





<div style="overflow-x:auto;">
  <span id="addfarmers"></span>
  <?PHP

  echo '<ul class="pagination pull-right">';

  if($page <=1){
   echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
 }
 else echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='masterlist?page=".($page-1)."'>Previous</a></li>";


  				//5 = 9, 4 = 7, 3 = 5								
   for ($x=max($page-3, 1); $x<=max(1, min($total_pages,$page+3)); $x++)
   {

    if($page == $x) { 
     echo '<li class="page-item active">
     <a class="page-link" href="masterlist?page='.$x.'">'.$x.'</a>
     </li>';} 
     else { echo '<li class="page-item"><a class="page-link" href="masterlist?page='.($x).'">'.$x.'</a></li>';}
   }
   if($page < $total_pages){
     echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='masterlist?page=".($page+1)."'>Next</a></li>";

   }
   else echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
   echo '</ul>';

   ?>


   <table class="table table-condensed table-hover table-sm" id="displaydata">
    <thead>
     <tr>        
      <th>Surname</th>
      <th>Firstname</th>
      <th>MI</th>
      <th>Birthdate</th>
      <th>Gender</th>
      <th>Civil Status</th>
      <th>Spouse</th>
      <th>Address</th>          
    </tr>
  </thead>
  <tbody>	
   <?php       
   $rs = $db->prepare("SELECT * FROM $table ORDER BY Surname  ASC LIMIT ?, ?");
   $rs->execute([$start_from, $results_per_page]);

   foreach($rs as $row){

    echo '<tr>';
    echo '<td>'.$row['Surname'].'</td>';
    echo '<td>'.$row['FirstName'].'</td>';
    echo '<td>'.$row['MI'].'</td>';
    echo '<td>'.$row['Birthdate'].'</td>';
    echo '<td>'.$row['Gender'].'</td>';
    echo '<td>'.$row['CivilStatus'].'</td>';
    echo '<td>'.$row['Spouse'].'</td>';
    if(!empty($row['Address'])) {
    echo '<td>'.strtoupper($row['Address']).',  '.strtoupper($row['Barangay']).',  '.strtoupper($row['Municipality']).', '.strtoupper($row['Province']).'</td>';
  }
  else
  {
   echo '<td>'.strtoupper($row['Barangay']).', '.strtoupper($row['Municipality']).', '.strtoupper($row['Province']).'</td>';  
 }   
    echo '</tr>';  

  }
  ?>


</tbody>
</table>

</div>
<!-- Footer-->
<hr>
<p class="text-center"><small>© Copyrighted <?php echo $_SESSION['insurance']; ?></small>
 <br><small><a href="#top"><i class="fa fa-angle-double-up" style="font-size: 24px;"></i></a>
 </p>                             
 <!-- end footer-->
</div>
</div>


</body>
</html>	