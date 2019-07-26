<<<<<<< HEAD
<?php
session_start();
require "../connection/conn.php";
require '../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;
use Classes\Rsbsa;

$programTbls = new programtables();


if (isset($_GET['core'])) {
     if (!empty($_GET['core'])) {
          $_SESSION['core'] = htmlentities($_GET['core']);
          switch ($_SESSION['core']) {
               case '1':
				$table = $programTbls->rsbsa();
				$p_type = new Rsbsa($table);							
                    break;
               case '2':
                    echo 'NON-RSBSA';
                    break;
               case '3':
                    echo 'YRRP';
                    break;
               default:
                    header('location: home');
                    break;
          }

     } else {
          $_SESSION['core'] = 0;
          header('location: home');
     }

}
?>
<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title><?php echo strtoupper($p_type::shortTitle()) ?> | Livestock Control</title>     
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">		
	<!-- <meta http-equiv="refresh" content="180"> -->
	<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
	<!--[if IE]><link rel="shortcut icon" href="../images/favicon-32x32.ico" ><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="../resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css">
	<link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="../resources/css/local.css">
	<link rel="stylesheet" href="../resources/css/animate.css">
	<link rel="stylesheet" href="../resources/multi-select/bootstrap-multiselect.css">
	<link rel="stylesheet" href="../resources/jquery-ui-1.12.1.custom/jquery-ui.css">
	<script src="../resources/bootstrap-4/js/jquery.js"></script>
	<script src="../resources/bootstrap-4/umd/js/popper.js"></script>
	<script src="../resources/bootstrap-4/js/bootstrap.js"></script>
	<script src="../resources/bootstrap-4/umd/js/popper.js"></script>
	<script type="text/javascript" src="../resources/assets/js/css3-mediaqueries.js"></script>
	<script type="text/javascript" src="../resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
    	<script type='text/javascript' src="../resources/html5shiv/src/html5shiv.js"></script>
  		<script type='text/javascript' src="../resources/Respond/src/respond.js"></script>
  	<![endif]-->
  	<script type="text/javascript" src="../resources/multi-select/bootstrap-multiselect.js"></script>  	
  	<script type ="text/javascript" src="../resources/js/rsbsa.js"></script>
  	<script type="text/javascript">
  		$(document).ready(function(){
  			$( "#assured-id" ).change(function(){
  				var val = $("#assured-id").val();
  				$.ajax({
  					type : 'post',
				url : '../bin/search/search_farmer.php', //Here you will fetch records 
				data :  'id='+ val, //Pass $id
				success : function(data){	
					$('#assured-name').trigger(':reset');				
					$('#province').trigger(':reset');

					if(!data.trim() =='') {

						var obj = $.parseJSON(data);
						var provinces = obj[0].province;
						var town = obj[0].town;					
						console.log(town);

					$('#assured-name').val(obj[0].name);//Show fetched data from database
					//$('#province').val(provinces);
					//$('#town').val(town);
					/*
					$('#province option').each(function(){
						if ($(this).text() == provinces){							
							$(this).parent().val($(this).val());
							
						}
					});
					$('#town option').val(town);
					*/
					
					
					$('#assured-name').prop('readonly', true);	
				}
				else {
					$('#assured-name').val('');
					$('#province').val('');
					$('#assured-name').trigger(':reset');				
					$('#province').trigger(':reset');
					
					$('#assured-name').prop('readonly', false);
					

				}
			},
			error : function(data){
				$('#assured-name').val('');
				$('#province').val('');
				$('#assured-name').trigger(':reset');				
				$('#province').trigger(':reset');
				

				$('#assured-name').prop('readonly', false);
			}
		});

  			});

  		});
  		$(window).scroll(function() {
  			sessionStorage.scrollTop = $(this).scrollTop();  			
  		});    
  		$(document).ready(function(){
  			if (sessionStorage.scrollTop != "undefined") {
  				$(window).scrollTop(sessionStorage.scrollTop);
  			}
  		});
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

  		$(document).ready(function() {
  			$('#searchBtn').click(function(e) {

  				var xz = $("#pref").val() + $("#srch").val();
  				$('#displaydata > tbody').empty();

  				$.ajax({
  					type: 'POST',
  					url: '../search.php',
  					data: 'ids='+ xz,
  					success: function(e){
  						$('#displaydata > tbody').html(e);
  					},
  					error: function(d){
  						alert("ERROR: " + d);
  					}
  				});
  			});
  		}); 
  		
  		$(document).ready(function () {
  			$(window).scroll(function () {
  				if ($(this).scrollTop() > 80) {
  					$('#nav2').fadeIn();
  				} else {
  					$('#nav2').fadeOut();
  				}  				
  			});     
  			$('.scrolledup').click(function () {
  				$("html, body").animate({
  					scrollTop: 0
  				}, 600);
  				return false;
  			}); 
  		});  
  	</script>
  	<style type="text/css">  	
  	.fixed-top-2 {
  		opacity: 0.4;
	  }
	/* if device screen LESS than or equal to 900px */
@media only screen and (max-width: 900px) {
    .addbutton {
      display: block !important;
    }
  }
  /* if device screen GREATER than or equal to 901px */
@media only screen and (min-width: 901px) {
    .addbutton {
      display: none !important;
    }
} 
  </style>
</head>
<body>
	<?php switch ($_SESSION['mode']) {
     case 'solar':
          echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
          break;

     case 'lumen':
          echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="top">';
          break;

     case 'darkly':
          echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="top">';
          break;

     case 'slate':
          echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
          break;

     case 'cyborg':
          echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
          break;
}
?>
	<div class="container">
		<a class="navbar-brand mx-auto" href="../home">
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
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						<span class="fa fa-navicon"></span> Programs
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="type?core=1">RSBSA</a>
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
     if ($_SESSION['stat'] == "Main") {
          ?>
							<a class="dropdown-item" href="../year">Insurance Year</a>
							<a class="dropdown-item" href="../farmers">Farmers List</a>
							<a class="dropdown-item" href="../accounts">Accounts</a>
							<a class="dropdown-item" href="../masterlist">RSBSA List</a>
							<a class="dropdown-item" href="../checkbox" target="_blank">Checklist</a>
							<a class="dropdown-item" href="../extract" target="_blank">Extract LIPs</a>
							<?php 
     }
     ?>
						<a class="dropdown-item" href="../reports">Reports</a>
						<a class="dropdown-item" href="../locations">Locations</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../logmeOut">
						<i class="fa fa-sign-out" style="font-size:15px"></i>
					</a>
				</li>  
			</ul>
			<ul class="navbar-nav ml-auto">
				<!-- add button -->
				<li class="nav-item"><a class="nav-link" href="#">
					<button class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Add Farmer</button>
				</a>
			</li>
			<!-- end add button -->
		</ul>
		<form class="form-inline my-2 my-lg-0" id="searchForm">            
			<div class="input-group">
				<div class="input-group-prepend">
					<select id="pref" class="input-group-text">
						<option value="f">Farmer</option>
						<option value="l">Logbook</option>
						<option value="i">IDS</option>
					</select>
				</div>
				<input type="text" id="srch" name="srch" class="form-control form-control-sm py-2" placeholder="Search">
				<div class="input-group-append">
					<button class="btn btn-default input-group-text" type="button" id="searchBtn">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
</nav> 

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top-2 fixed-bottom " id="nav2"> 
	<div class="container">    
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="scrolledup nav-link" href="#">Move To Top</a>
			</li>
		</ul> 
	</div>
</nav>

<div class="container-fluid">
	<div class="page-header" style="margin-top:50px;">
		<h2 class="display-5"><?php echo $p_type::longTitle() ?></h2>
		<div class="addbutton">
			<button class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">
				<i class="fa fa-plus-circle"></i>
			</button>
		</div>
		<hr>
	</div>
	<?PHP 
	/* ============== RESULTS DISPLAYED PER PAGE ==========  */
$results_per_page = 100;
	/* =======================================================*/
if (isset($_GET["page"])) {
     $page = $_GET["page"];
} else {
     $page = 1;
}

$start_from = ($page - 1) * $results_per_page;
if ($_SESSION['office'] == "Regional Office") {
     $rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table");
     $rs3->execute();
} else {
     $rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table WHERE office_assignment = ?");
     $rs3->execute([$_SESSION['office']]);
}
foreach ($rs3 as $row) {
     $getcount = $row['total'];
}
				// calculate total pages with results
$total_pages = ceil(round($getcount) / $results_per_page);
?>





	<div style="overflow-x:auto;">
		<span id="addfarmers"></span>
		<?PHP

     echo '<ul class="pagination pull-right">';

     if ($page <= 1) {
          echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
     } else echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='type?core=".$_GET['core']."&page=" . ($page - 1) . "'>Previous</a></li>";


  				//5 = 9, 4 = 7, 3 = 5								
     for ($x = max($page - 3, 1); $x <= max(1, min($total_pages, $page + 3)); $x++) {

          if ($page == $x) {
               echo '<li class="page-item active">
					<a class="page-link" href="type?core='.$_GET['core'].'&page=' . $x . '">' . $x . '</a>
					</li>';
          } else {
               echo '<li class="page-item"><a class="page-link" href="type?core='.$_GET['core'].'&page=' . ($x) . '">' . $x . '</a></li>';
          }
     }
     if ($page < $total_pages) {
          echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='".$_GET['core']."page=" . ($page + 1) . "'>Next</a></li>";

     } else echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
     echo '</ul>';

     ?>

				<form method="post" action="../printing/printbatchProcessingslipRSBSA" target="_blank">
					<table class="table table-condensed table-hover table-sm" id="displaydata">


						<thead>
							<tr>
								<th class="text-center">
									<div class="btn-group" role="group" aria-label="Action Button">
										<div class="btn-group" role="group">
											<button id="actionBtnDropList" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
											<div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="printBtn" value="Print Processing Slip">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="pIDSBtn" value="Print IDS">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="evaluateBtn" value="Evaluate">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="cancelBtn" value="Cancel">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="activeBtn" value="Set Active"> 
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="t_agri"  value="Move to AGRI-AGRA">             
											</div>           
										</div>
									</th>
									<th>Date Received</th>
									<th>Livestock Policy Number</th>
									<th>Name Of Farmers / Assured</th>
									<th>ID</th>

									<th>Address</th>
									<th>Kind of Animal</th>
									<th>Heads</th>
									<th>LB#</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>

							</thead>
							<tbody>	





								<?php

          if ($_SESSION['office'] == "Regional Office") {
               $rs = $db->prepare("SELECT * FROM $table ORDER BY idsnumber DESC LIMIT ?, ?");
               $rs->execute([$start_from, $results_per_page]);
          } else {
               $rs = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? ORDER BY idsnumber DESC LIMIT ?, ?");
               $rs->execute([$_SESSION['office'], $start_from, $results_per_page]);
          }



          foreach ($rs as $row) {


               if ($row['status'] == "active") {
                    echo '<tr>';
                    echo '<td class="text-center">									
						<input type="checkbox" name="chkPrint[]" value="' . $row['idsnumber'] . '" id="i' . $row['idsnumber'] . '"  style="width:20px; height:20px; cursor: pointer;">
									</td>';
                    echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                    echo '<td class="text-success">' . $row['f_id'] . '</td>';

                    echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                    echo '<td>' . $row['animal'] . '</td>';
                    echo '<td class="text-center">' . $row['heads'] . '</td>';

                    if (!$row['lslb'] == "0") {
                         echo '<td><a class="btn btn-primary btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                    } else {
                         echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                    }

                    echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . '' . $row['idsprogram'] . '" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                    echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                    if (!$row['lslb'] != "0") {
                         echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';
                    } else {
                         echo '<td></td>';
                    }

                    echo '</tr>';
               } else if ($row['status'] == "cancelled") {
                    echo '<tr>';
                    echo '<td class="text-center"></td>';
                    echo '<td id="i"' . $row['idsnumber'] . '>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong class="text-danger">' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" disabled>' . $row['assured'] . '</td>';
                    echo '<td class="text-success">' . $row['f_id'] . '</td>';


                    echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                    echo '<td>' . $row['animal'] . '</td>';
                    echo '<td class="text-center">' . $row['heads'] . '</td>';

                    echo '<td>&nbsp;</td>';
                    echo '<td>&nbsp;</td>';
                    echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                    echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';

                    echo '</tr>';
               } else if ($row['status'] == "evaluated") {
                    echo '<tr>';
                    echo '<td><span class="badge badge-warning">Evaluated</span></td>';
                    echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                    echo '<td class="text-success">' . $row['f_id'] . '</td>';

                    echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                    echo '<td>' . $row['animal'] . '</td>';
                    echo '<td class="text-center">' . $row['heads'] . '</td>';


                    if (!$row['lslb'] == "0") {
                         echo '<td><a class="btn btn-info btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                    } else {
                         echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                    }

                    echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                    echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                    echo '<td>&nbsp;</td>';

                    echo '</tr>';
               } else if ($row['status'] == "hold") {
                    echo '<tr>';
                    echo '<td class="text-center"><span class="badge badge-danger">HOLD</span></td>';
                    echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                    echo '<td class="text-success">' . $row['f_id'] . '</td>';

                    echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                    echo '<td>' . $row['animal'] . '</td>';
                    echo '<td class="text-center">' . $row['heads'] . '</td>';

                    if (!$row['lslb'] == "0") {
                         echo '<td><a class="btn btn-outline-primary btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                    } else {
                         echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                    }

                    echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . '' . $row['idsprogram'] . '" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                    echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                    if (!$row['lslb'] != "0") {
                         echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';
                    } else {
                         echo '<td></td>';
                    }

                    echo '</tr>';
               }
          }
          ?>


							</tbody>
						</table>
					</form>				
				</div>
				<!-- Footer-->
				<hr>
				<p class="text-center"><small>© Copyrighted <?php echo $_SESSION['insurance']; ?></small>
					<br><small>
					</p>                             
					<!-- end footer-->
				</div>
			</div>
</head>
<body>
    
</body>
=======
<?php
session_start();
require "../connection/conn.php";
require '../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;
use Classes\Rsbsa;

$programTbls = new programtables();


if (isset($_GET['core'])) {
     if (!empty($_GET['core'])) {
          $_SESSION['core'] = htmlentities($_GET['core']);
          switch ($_SESSION['core']) {
               case '1':
				$table = $programTbls->rsbsa();
				$p_type = new Rsbsa($table);							
                    break;
               case '2':
                    echo 'NON-RSBSA';
                    break;
               case '3':
                    echo 'YRRP';
                    break;
               default:
                    header('location: home');
                    break;
          }

     } else {
          $_SESSION['core'] = 0;
          header('location: home');
     }

}
?>
<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title><?php echo strtoupper($p_type::shortTitle()) ?> | Livestock Control</title>     
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">		
	<!-- <meta http-equiv="refresh" content="180"> -->
	<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
	<!--[if IE]><link rel="shortcut icon" href="../images/favicon-32x32.ico" ><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="../resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css">
	<link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="../resources/css/local.css">
	<link rel="stylesheet" href="../resources/css/animate.css">
	<link rel="stylesheet" href="../resources/multi-select/bootstrap-multiselect.css">
	<link rel="stylesheet" href="../resources/jquery-ui-1.12.1.custom/jquery-ui.css">
	<script src="../resources/bootstrap-4/js/jquery.js"></script>
	<script src="../resources/bootstrap-4/umd/js/popper.js"></script>
	<script src="../resources/bootstrap-4/js/bootstrap.js"></script>
	<script src="../resources/bootstrap-4/umd/js/popper.js"></script>
	<script type="text/javascript" src="../resources/assets/js/css3-mediaqueries.js"></script>
	<script type="text/javascript" src="../resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
    	<script type='text/javascript' src="../resources/html5shiv/src/html5shiv.js"></script>
  		<script type='text/javascript' src="../resources/Respond/src/respond.js"></script>
  	<![endif]-->
  	<script type="text/javascript" src="../resources/multi-select/bootstrap-multiselect.js"></script>  	
  	<script type ="text/javascript" src="../resources/js/rsbsa.js"></script>
  	<script type="text/javascript">
  		$(document).ready(function(){
  			$( "#assured-id" ).change(function(){
  				var val = $("#assured-id").val();
  				$.ajax({
  					type : 'post',
				url : '../bin/search/search_farmer.php', //Here you will fetch records 
				data :  'id='+ val, //Pass $id
				success : function(data){	
					$('#assured-name').trigger(':reset');				
					$('#province').trigger(':reset');

					if(!data.trim() =='') {

						var obj = $.parseJSON(data);
						var provinces = obj[0].province;
						var town = obj[0].town;					
						console.log(town);

					$('#assured-name').val(obj[0].name);//Show fetched data from database
					//$('#province').val(provinces);
					//$('#town').val(town);
					/*
					$('#province option').each(function(){
						if ($(this).text() == provinces){							
							$(this).parent().val($(this).val());
							
						}
					});
					$('#town option').val(town);
					*/
					
					
					$('#assured-name').prop('readonly', true);	
				}
				else {
					$('#assured-name').val('');
					$('#province').val('');
					$('#assured-name').trigger(':reset');				
					$('#province').trigger(':reset');
					
					$('#assured-name').prop('readonly', false);
					

				}
			},
			error : function(data){
				$('#assured-name').val('');
				$('#province').val('');
				$('#assured-name').trigger(':reset');				
				$('#province').trigger(':reset');
				

				$('#assured-name').prop('readonly', false);
			}
		});

  			});

  		});
  		$(window).scroll(function() {
  			sessionStorage.scrollTop = $(this).scrollTop();  			
  		});    
  		$(document).ready(function(){
  			if (sessionStorage.scrollTop != "undefined") {
  				$(window).scrollTop(sessionStorage.scrollTop);
  			}
  		});
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

  		$(document).ready(function() {
  			$('#searchBtn').click(function(e) {

  				var xz = $("#pref").val() + $("#srch").val();
  				$('#displaydata > tbody').empty();

  				$.ajax({
  					type: 'POST',
  					url: '../search.php',
  					data: 'ids='+ xz,
  					success: function(e){
  						$('#displaydata > tbody').html(e);
  					},
  					error: function(d){
  						alert("ERROR: " + d);
  					}
  				});
  			});
  		}); 
  		
  		$(document).ready(function () {
  			$(window).scroll(function () {
  				if ($(this).scrollTop() > 80) {
  					$('#nav2').fadeIn();
  				} else {
  					$('#nav2').fadeOut();
  				}  				
  			});     
  			$('.scrolledup').click(function () {
  				$("html, body").animate({
  					scrollTop: 0
  				}, 600);
  				return false;
  			}); 
  		});  
  	</script>
  	<style type="text/css">  	
  	.fixed-top-2 {
  		opacity: 0.4;
	  }
	/* if device screen LESS than or equal to 900px */
@media only screen and (max-width: 900px) {
    .addbutton {
      display: block !important;
    }
  }
  /* if device screen GREATER than or equal to 901px */
@media only screen and (min-width: 901px) {
    .addbutton {
      display: none !important;
    }
} 
  </style>
</head>
<body>
	<?php switch ($_SESSION['mode']) {
     case 'solar':
          echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
          break;

     case 'lumen':
          echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="top">';
          break;

     case 'darkly':
          echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="top">';
          break;

     case 'slate':
          echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
          break;

     case 'cyborg':
          echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
          break;
}
?>
	<div class="container">
		<a class="navbar-brand mx-auto" href="../home">
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
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						<span class="fa fa-navicon"></span> Programs
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="type?core=1">RSBSA</a>
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
     if ($_SESSION['stat'] == "Main") {
          ?>
							<a class="dropdown-item" href="../year">Insurance Year</a>
							<a class="dropdown-item" href="../farmers">Farmers List</a>
							<a class="dropdown-item" href="../accounts">Accounts</a>
							<a class="dropdown-item" href="../masterlist">RSBSA List</a>
							<a class="dropdown-item" href="../checkbox" target="_blank">Checklist</a>
							<a class="dropdown-item" href="../extract" target="_blank">Extract LIPs</a>
							<?php 
     }
     ?>
						<a class="dropdown-item" href="../reports">Reports</a>
						<a class="dropdown-item" href="../locations">Locations</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../logmeOut">
						<i class="fa fa-sign-out" style="font-size:15px"></i>
					</a>
				</li>  
			</ul>
			<ul class="navbar-nav ml-auto">
				<!-- add button -->
				<li class="nav-item"><a class="nav-link" href="#">
					<button class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Add Farmer</button>
				</a>
			</li>
			<!-- end add button -->
		</ul>
		<form class="form-inline my-2 my-lg-0" id="searchForm">            
			<div class="input-group">
				<div class="input-group-prepend">
					<select id="pref" class="input-group-text">
						<option value="f">Farmer</option>
						<option value="l">Logbook</option>
						<option value="i">IDS</option>
					</select>
				</div>
				<input type="text" id="srch" name="srch" class="form-control form-control-sm py-2" placeholder="Search">
				<div class="input-group-append">
					<button class="btn btn-default input-group-text" type="button" id="searchBtn">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
</nav> 

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top-2 fixed-bottom " id="nav2"> 
	<div class="container">    
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="scrolledup nav-link" href="#">Move To Top</a>
			</li>
		</ul> 
	</div>
</nav>

<div class="container-fluid">
	<div class="page-header" style="margin-top:50px;">
		<h2 class="display-5"><?php echo $p_type::longTitle() ?></h2>
		<div class="addbutton">
			<button class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">
				<i class="fa fa-plus-circle"></i>
			</button>
		</div>
		<hr>
	</div>
	<?PHP 
	/* ============== RESULTS DISPLAYED PER PAGE ==========  */
$results_per_page = 100;
	/* =======================================================*/
if (isset($_GET["page"])) {
     $page = $_GET["page"];
} else {
     $page = 1;
}

$start_from = ($page - 1) * $results_per_page;
if ($_SESSION['office'] == "Regional Office") {
     $rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table");
     $rs3->execute();
} else {
     $rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table WHERE office_assignment = ?");
     $rs3->execute([$_SESSION['office']]);
}
foreach ($rs3 as $row) {
     $getcount = $row['total'];
}
				// calculate total pages with results
$total_pages = ceil(round($getcount) / $results_per_page);
?>





	<div style="overflow-x:auto;">
		<span id="addfarmers"></span>
		<?PHP

     echo '<ul class="pagination pull-right">';

     if ($page <= 1) {
          echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
     } else echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='type?core=".$_GET['core']."&page=" . ($page - 1) . "'>Previous</a></li>";


  				//5 = 9, 4 = 7, 3 = 5								
     for ($x = max($page - 3, 1); $x <= max(1, min($total_pages, $page + 3)); $x++) {

          if ($page == $x) {
               echo '<li class="page-item active">
					<a class="page-link" href="type?core='.$_GET['core'].'&page=' . $x . '">' . $x . '</a>
					</li>';
          } else {
               echo '<li class="page-item"><a class="page-link" href="type?core='.$_GET['core'].'&page=' . ($x) . '">' . $x . '</a></li>';
          }
     }
     if ($page < $total_pages) {
          echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='".$_GET['core']."page=" . ($page + 1) . "'>Next</a></li>";

     } else echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
     echo '</ul>';

     ?>

				<form method="post" action="../printing/printbatchProcessingslipRSBSA" target="_blank">
					<table class="table table-condensed table-hover table-sm" id="displaydata">


						<thead>
							<tr>
								<th class="text-center">
									<div class="btn-group" role="group" aria-label="Action Button">
										<div class="btn-group" role="group">
											<button id="actionBtnDropList" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
											<div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="printBtn" value="Print Processing Slip">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="pIDSBtn" value="Print IDS">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="evaluateBtn" value="Evaluate">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="cancelBtn" value="Cancel">
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="activeBtn" value="Set Active"> 
												<input type="submit" class="dropdown-item btn btn-outline-primary btn-sm" name="t_agri"  value="Move to AGRI-AGRA">             
											</div>           
										</div>
									</th>
									<th>Date Received</th>
									<th>Livestock Policy Number</th>
									<th>Name Of Farmers / Assured</th>
									<th>ID</th>

									<th>Address</th>
									<th>Kind of Animal</th>
									<th>Heads</th>
									<th>LB#</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>

							</thead>
							<tbody>	





								<?php

          if ($_SESSION['office'] == "Regional Office") {
               $rs = $db->prepare("SELECT * FROM $table ORDER BY idsnumber DESC LIMIT ?, ?");
               $rs->execute([$start_from, $results_per_page]);
          } else {
               $rs = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? ORDER BY idsnumber DESC LIMIT ?, ?");
               $rs->execute([$_SESSION['office'], $start_from, $results_per_page]);
          }



          foreach ($rs as $row) {


               if ($row['status'] == "active") {
                    echo '<tr>';
                    echo '<td class="text-center">									
						<input type="checkbox" name="chkPrint[]" value="' . $row['idsnumber'] . '" id="i' . $row['idsnumber'] . '"  style="width:20px; height:20px; cursor: pointer;">
									</td>';
                    echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                    echo '<td class="text-success">' . $row['f_id'] . '</td>';

                    echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                    echo '<td>' . $row['animal'] . '</td>';
                    echo '<td class="text-center">' . $row['heads'] . '</td>';

                    if (!$row['lslb'] == "0") {
                         echo '<td><a class="btn btn-primary btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                    } else {
                         echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                    }

                    echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . '' . $row['idsprogram'] . '" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                    echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                    if (!$row['lslb'] != "0") {
                         echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';
                    } else {
                         echo '<td></td>';
                    }

                    echo '</tr>';
               } else if ($row['status'] == "cancelled") {
                    echo '<tr>';
                    echo '<td class="text-center"></td>';
                    echo '<td id="i"' . $row['idsnumber'] . '>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong class="text-danger">' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" disabled>' . $row['assured'] . '</td>';
                    echo '<td class="text-success">' . $row['f_id'] . '</td>';


                    echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                    echo '<td>' . $row['animal'] . '</td>';
                    echo '<td class="text-center">' . $row['heads'] . '</td>';

                    echo '<td>&nbsp;</td>';
                    echo '<td>&nbsp;</td>';
                    echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                    echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';

                    echo '</tr>';
               } else if ($row['status'] == "evaluated") {
                    echo '<tr>';
                    echo '<td><span class="badge badge-warning">Evaluated</span></td>';
                    echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                    echo '<td class="text-success">' . $row['f_id'] . '</td>';

                    echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                    echo '<td>' . $row['animal'] . '</td>';
                    echo '<td class="text-center">' . $row['heads'] . '</td>';


                    if (!$row['lslb'] == "0") {
                         echo '<td><a class="btn btn-info btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                    } else {
                         echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                    }

                    echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                    echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                    echo '<td>&nbsp;</td>';

                    echo '</tr>';
               } else if ($row['status'] == "hold") {
                    echo '<tr>';
                    echo '<td class="text-center"><span class="badge badge-danger">HOLD</span></td>';
                    echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                    echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                    echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                    echo '<td class="text-success">' . $row['f_id'] . '</td>';

                    echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                    echo '<td>' . $row['animal'] . '</td>';
                    echo '<td class="text-center">' . $row['heads'] . '</td>';

                    if (!$row['lslb'] == "0") {
                         echo '<td><a class="btn btn-outline-primary btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                    } else {
                         echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                    }

                    echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . '' . $row['idsprogram'] . '" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                    echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                    if (!$row['lslb'] != "0") {
                         echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';
                    } else {
                         echo '<td></td>';
                    }

                    echo '</tr>';
               }
          }
          ?>


							</tbody>
						</table>
					</form>				
				</div>
				<!-- Footer-->
				<hr>
				<p class="text-center"><small>© Copyrighted <?php echo $_SESSION['insurance']; ?></small>
					<br><small>
					</p>                             
					<!-- end footer-->
				</div>
			</div>
</head>
<body>
    
</body>
>>>>>>> 2f7b070fceb186b0768dfabed342086e2db576da
</html>