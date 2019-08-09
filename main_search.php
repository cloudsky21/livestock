<!-- SEARCH PAGE */ -->

<?php
session_start();
require 'connection/conn.php';
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;

/* @param $obj is list of all table names*/

$obj = new programtables();

$programs = $obj->tableList();
$s_farmer = "";
$r_found = 0;
?>


<!DOCTYPE html>
<html>

<head>
    <title>Farmer Search | Livestock Control</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images//favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="resources/bootswatch/default/bootstrap.css">
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="resources/css/local.css">
    <link rel="stylesheet" href="resources/css/animate.css">
    <link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
    <link rel="stylesheet" href="resources/jquery-ui-1.12.1.custom/jquery-ui.css">
    <script src="resources/bootstrap-4/js/jquery.js"></script>
    <script src="resources/bootstrap-4/umd/js/popper.js"></script>
    <script src="resources/bootstrap-4/js/bootstrap.js"></script>

    <script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
    <script type="text/javascript" src="resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
        $('th').click(function() {
            var table = $(this).parents('table').eq(0)
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
            this.asc = !this.asc
            if (!this.asc) {
                rows = rows.reverse()
            }
            for (var i = 0; i < rows.length; i++) {
                table.append(rows[i])
            }
        })

        function comparer(index) {
            return function(a, b) {
                var valA = getCellValue(a, index),
                    valB = getCellValue(b, index)
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(
                    valB)
            }
        }

        function getCellValue(row, index) {
            return $(row).children('td').eq(index).text()
        }
    });
    </script>
    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    $(window).scroll(function() {
        sessionStorage.scrollTop = $(this).scrollTop();
    });
    $(document).ready(function() {
        if (sessionStorage.scrollTop != "undefined") {
            $(window).scrollTop(sessionStorage.scrollTop);
        }
    });
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="jumbotron" style="margin-top: 50px;">
            <h1 class="display-5">Search Farmer</h1>
            <hr class="my-4">
            <form action="" method="post" autocomplete="off">
                <div class="form-group">
                    <label>Options</label>
                    <select name="options" class="form-control">
                        <option value="ID">Farmer ID</option>
                        <option value="default" selected="true">--</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="f_search" class="sr-only">Search</label>
                    <input type="text" id="f_search" name="f_search" class="form-control" placeholder="Farmer" required>
                </div>
                <p class="lead">
                    <button class="btn btn-primary" role="button" type="submit" name="searchBtn">Search</button>
                </p>
            </form>
        </div> <!-- jumbotron-->



        <!-- Table-->
        <table class="table table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th style="cursor: pointer;">Logbook</th>
                    <th style="cursor: pointer;">Program</th>
                    <th style="cursor: pointer;">Farmer ID</th>
                    <th style="cursor: pointer;">Farmer</th>
                    <th style="cursor: pointer;">LIP</th>
                    <th style="cursor: pointer;">Animal</th>
                    <th style="cursor: pointer;">Heads</th>
                    <th style="cursor: pointer;">Tag / COLC</th>
                    <th style="cursor: pointer;">FROM</th>
                    <th style="cursor: pointer;">TO</th>
                    <th style="cursor: pointer;">Status</th>
                    <th style="cursor: pointer;">Comments</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if (isset($_POST['searchBtn']) && !empty($_POST['f_search'])) {
					$unwanted = array("&NTILDE;" => "Ñ");

					$s_farmer = strtr(mb_strtoupper(htmlentities($_POST['f_search'], ENT_QUOTES)), $unwanted);


					$r_found = 0;
					$count = 0;



					switch ($_POST['options']) {
						case 'ID':
							foreach ($programs as $table) {
								$result = $db->prepare("SELECT * FROM $table WHERE f_id LIKE ? or f_id = ? ORDER BY assured DESC");
								$result->execute(["%" . $s_farmer . "%", $s_farmer]);

								$count = $result->rowcount();

								if ($count > 0) {

									foreach ($result as $key) {
										echo '<tr>';
										echo '<td>' . $key['lslb'] . '</td>';
										echo '<td>' . $key['program'] . '</td>';
										echo '<td>' . $key['f_id'] . '</td>';
										echo '<td>' . $key['assured'] . '</td>';
										echo '<td>' . $key['lsp'] . sprintf("%04d", $key['idsnumber']) . '-' . $key['idsprogram'] . '</td>';
										echo '<td>' . $key['animal'] . '</td>';
										echo '<td>' . $key['heads'] . '</td>';
										echo '<td>' . $key['tag'] . '</td>';
										echo '<td>' . date("m/d/Y", strtotime($key['Dfrom'])) . '</td>';
										echo '<td>' . date("m/d/Y", strtotime($key['Dto'])) . '</td>';
										switch ($key['status']) {
											case 'active':
												echo '<td><span class="badge badge-dark">Encoding</span></td>';
												break;

											case 'evaluated':
												echo '<td><span class="badge badge-success">Evaluated</span></td>';
												break;

											case 'cancelled':
												echo '<td><span class="badge badge-danger">Cancelled</span></td>';
												break;

											case 'hold':
												echo '<td><span class="badge badge-info">Cancelled</span></td>';
												break;

											default:
												echo '<td><span class="badge badge-light">Verify</span></td>';
												break;
										}
										echo '<td>' . $key['comments'] . '</td>';
										echo '</tr>';
									}
									$r_found += $count;
								}
							}
							break;

						case 'default':
							foreach ($programs as $table) {
								if (preg_match('/(regular)/', $table, $matches)) {
									$regular = $obj->regular();
									$result = $db->prepare("SELECT * FROM $regular WHERE assured LIKE ? ORDER BY assured DESC");
									$result->execute(["%" . $s_farmer . "%"]);

									$count = $result->rowcount();

									if ($count > 0) {

										foreach ($result as $key) {
											echo '<tr>';
											echo '<td>' . $key['lslb'] . '</td>';
											echo '<td>Regular</td>';
											echo '<td>' . $key['f_id'] . '</td>';
											echo '<td>' . $key['assured'] . '</td>';
											echo '<td>' . $key['lsp'] . sprintf("%04d", $key['idsnumber']) . '</td>';
											echo '<td>' . $key['animal'] . '</td>';
											echo '<td>' . $key['heads'] . '</td>';
											echo '<td>' . $key['tag'] . '</td>';
											echo '<td>' . date("m/d/Y", strtotime($key['Dfrom'])) . '</td>';
											echo '<td>' . date("m/d/Y", strtotime($key['Dto'])) . '</td>';
											switch ($key['status']) {
												case 'active':
													echo '<td><span class="badge badge-dark">Encoding</span></td>';
													break;

												case 'evaluated':
													echo '<td><span class="badge badge-success">Evaluated</span></td>';
													break;

												case 'cancelled':
													echo '<td><span class="badge badge-danger">Cancelled</span></td>';
													break;

												case 'hold':
													echo '<td><span class="badge badge-info">Hold</span></td>';
													break;

												default:
													echo '<td><span class="badge badge-light">Verify</span></td>';
													break;
											}
											echo '<td>' . $key['comments'] . '</td>';
											echo '</tr>';
										}
										$r_found += $count;
									}
								} else {
									$result = $db->prepare("SELECT * FROM $table WHERE assured LIKE ? ORDER BY assured DESC");
									$result->execute(["%" . $s_farmer . "%"]);

									$count = $result->rowcount();

									if ($count > 0) {

										foreach ($result as $key) {
											echo '<tr>';
											echo '<td>' . $key['lslb'] . '</td>';
											echo '<td>' . $key['program'] . '</td>';
											echo '<td>' . $key['f_id'] . '</td>';
											echo '<td>' . $key['assured'] . '</td>';
											echo '<td><strong>' . $key['lsp'] . sprintf("%04d", $key['idsnumber']) . '-' . $key['idsprogram'] . '</strong></td>';
											echo '<td>' . $key['animal'] . '</td>';
											echo '<td>' . $key['heads'] . '</td>';
											echo '<td>' . $key['tag'] . '</td>';
											echo '<td>' . date("m/d/Y", strtotime($key['Dfrom'])) . '</td>';
											echo '<td>' . date("m/d/Y", strtotime($key['Dto'])) . '</td>';
											switch ($key['status']) {
												case 'active':
													echo '<td><span class="badge badge-dark">Encoding</span></td>';
													break;

												case 'evaluated':
													echo '<td><span class="badge badge-success">Evaluated</span></td>';
													break;

												case 'cancelled':
													echo '<td><span class="badge badge-danger">Cancelled</span></td>';
													break;

												case 'hold':
													echo '<td><span class="badge badge-info">Hold</span></td>';
													break;

												default:
													echo '<td><span class="badge badge-light">Verify</span></td>';
													break;
											}
											echo '<td>' . $key['comments'] . '</td>';
											echo '</tr>';
										}
										$r_found += $count;
									}
								}
							}
							break;
					}
				}
				?>
            </tbody>

        </table>

        <table id="table1" class="table table-bordered table-condensed table-hover">
            <?php
			echo '<tr>';
			echo '<td colspan="10">Looking for: <strong>' . $s_farmer . '</strong></td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td colspan="10">Records Found: <strong>' . number_format($r_found) . '</strong></td>';
			echo '</tr>';
			unset($_POST['options']);
			unset($_POST['s_farmer']);

			?>
        </table>
    </div> <!-- container-->
</body>

</html>