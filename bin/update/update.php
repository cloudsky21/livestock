<?PHP
session_start();
require_once "../../connection/conn.php";
require '../../myload.php';

use Classes\programtables;

$obj = new programtables();
$table = $obj->rsbsa();

if (isset($_POST['rowid'])) {
    $ids = htmlentities($_POST['rowid']);
    $result = $db->prepare("SELECT * FROM $table WHERE idsnumber = ?");
    $result->execute([$ids]);
    foreach ($result as $row) {
        if (isset($_SESSION['group']) || empty($row['groupName'])) {
            $group = $_SESSION['group'];
        } else {
            $group = $row['groupName'];
        }
        $assured = $row['assured'];
        $province = $row['province'];
        $town = $row['town'];
        $fCount = $row['farmers'];
        $hCount = $row['heads'];
        $kAnimal = $row['animal'];
        $rate = $row['rate'];
        $aCover = $row['amount_cover'];
        $from = $row['Dfrom'];
        $to = $row['Dto'];
        $stats = $row['status'];
        $logbook = ($row['lslb'] == '0') ? ' ' : $row['lslb'];
        $prem_loading = $row['loading'];
        $iu = $row['iu'];
        $program = $row['program'];
        $rcv = $row['date_r'];
        $application_form = $row['imagepath'];
        $tag = $row['tag'];
        $f_id = $row['f_id'];
        $notes = $row['comments'];
        $rsbsa_type = $row['idsprogram'];

    }
}
?>

<?php

if ($stats == 'evaluated') {
    # Read only
    ?>

	<table class="table table-sm table-condensed">
	<tr>
		<th scope="row"><label for="lslb">Logbook No.:</label></th>
		<td><input type="number" id="lslb" name="lslb" value="<?PHP echo $logbook; ?>" step="any" min=0 class="form-control form-control-sm" readonly></td>
	</tr>
	<?php
if ($_SESSION['stat'] == 'Main') {
        ?>
		<th scope="row">
			<label for="stt">Status:</label>
			</th>
				<td>
					<select name="stt" id="stt" class="form-control form-control-sm" >
						<option value="active"<?PHP if ($stats == "active") {
            echo "selected";
        }
        ?>>Active</option>
						<option value="cancelled"<?PHP if ($stats == "cancelled") {
            echo "selected";
        }
        ?>>Cancelled</option>
						<option value="evaluated"<?PHP if ($stats == "evaluated") {
            echo "selected";
        }
        ?>>Evaluated</option>
						<option value="hold"<?PHP if ($stats == "hold") {
            echo "selected";
        }
        ?>>Hold</option>
					</select>
				</td>
		<?php

    } else {
        ?>
		<th scope="row">
			<label for="stt">Status:</label>
			</th>
				<td>
					<select name="stt" id="stt" class="form-control form-control-sm" readonly>
						<option value="active"<?PHP if ($stats == "active") {
            echo "selected";
        }
        ?>>Active</option>
						<option value="cancelled"<?PHP if ($stats == "cancelled") {
            echo "selected";
        }
        ?>>Cancelled</option>
						<option value="evaluated"<?PHP if ($stats == "evaluated") {
            echo "selected";
        }
        ?>>Evaluated</option>
						<option value="hold"<?PHP if ($stats == "hold") {
            echo "selected";
        }
        ?>>Hold</option>
					</select>
				</td>
		<?php
}
    ?>
	<tr>
		<th scope="row"><label for="group-name">Group Name: </label></th>
		<td><input type="text" name="group-name" id="group-name" placeholder="DA/LGU or et. al." required maxlength="200" value="<?PHP echo $group; ?>" class="form-control form-control-sm" readonly></td>
	</tr>
	<tr>
		<th scope="row"><label for="type_rsbsa">Type of RSBSA (optional): </label></th>
		<td>
            <select id="type_rsbsa" name="type_rsbsa" class="form-control form-control-sm" readonly>
                <option value="PPPP" <?php if ($rsbsa_type == 'PPPP') {echo "selected";}?>>Default</option>
                <option value="PPPP-ARB" <?php if ($rsbsa_type == 'PPPP-ARB') {echo "selected";}?>>DAR</option>
            </select>
        </td>
		</tr>
	<tr>
		<th scope="row"><label for="assured-id" >Farmer ID:</label></th>
		<td><input type="text" name="assured-id" id="assured-id" placeholder="Juan Dela Cruz et. al." required maxlength="200" value="<?PHP echo $assured; ?>" class="form-control form-control-sm" readonly></td>
	</tr>
	<tr>
		<th scope="row"><label for="assured-name" >Name of Assured:</label></th>
		<td><input type="text" name="assured-name" id="assured-name" placeholder="Juan Dela Cruz et. al." required maxlength="200" value="<?PHP echo $assured; ?>" class="form-control form-control-sm" readonly></td>
	</tr>
	<tr>
		<th scope="row"><label for="address" >Province</label></th>
		<td><select id="province" name="province" placeholder="Leyte" class="form-control form-control-sm" readonly>
		<option value="Leyte" <?php if ($province == "LEYTE") {
        echo "selected";
    }?>>LEYTE</option>
		<option value="Southern Leyte" <?php if ($province == "SOUTHERN LEYTE") {
        echo "selected";
    }?>>SOUTHERN LEYTE</option>
		<option value="Biliran" <?php if ($province == "BILIRAN") {
        echo "selected";
    }?>>BILIRAN</option>
		<option value="Northern Samar" <?php if ($province == "NORTHERN SAMAR") {
        echo "selected";
    }?>>NORTHERN SAMAR</option>
		<option value="Eastern Samar" <?php if ($province == "EASTERN SAMAR") {
        echo "selected";
    }?>>EASTERN SAMAR</option>
		<option value="Western Samar" <?php if ($province == "WESTERN SAMAR") {
        echo "selected";
    }?>>WESTERN SAMAR</option>
	</select></td>
	</tr>
	<tr>
		<th scope="row">
			<label for="address" >Town</label>
			</th>
		<td>
			<input type="text" id="town" name="town" placeholder="Abuyog" required maxlength="200"  value="<?PHP echo $town; ?>" class="form-control form-control-sm" readonly>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="farmer-count">Farmers</label>
			</th>
		<td>
			<input type="number" id="farmer-count" name="farmer-count" required  min=0 step="any"  value="<?PHP echo $fCount; ?>" class="form-control form-control-sm" readonly>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="head-count">Heads</label>
			</th>
		<td>
			<input type="number" id="head-count" name="head-count" required  min=0 step="any" value="<?PHP echo $hCount; ?>" class="form-control form-control-sm" readonly>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="animal-type">Kind of Animal</label>
			</th>
		<td>
			<select id="animal-type" name="animal-type" class="form-control form-control-sm" readonly>
		<option value="--------">---------</option>
		<option value="Carabao-Breeder"<?PHP if ($kAnimal == "Carabao-Breeder") {
        echo "selected";
    }
    ?>>Carabao Breeder</option>
		<option value="Carabao-Draft"<?PHP if ($kAnimal == "Carabao-Draft") {
        echo "selected";
    }
    ?>>Carabao Draft</option>
		<option value="Carabao-Dairy"<?PHP if ($kAnimal == "Carabao-Dairy") {
        echo "selected";
    }
    ?>>Carabao Dairy</option>
		<option value="Carabao-Fattener"<?PHP if ($kAnimal == "Carabao-Fattener") {
        echo "selected";
    }
    ?>>Carabao Fattener</option>
		<option value="--------">---------</option>
		<option value="Cattle-Breeder"<?PHP if ($kAnimal == "Cattle-Breeder") {
        echo "selected";
    }
    ?>>Cattle Breeder</option>
		<option value="Cattle-Draft"<?PHP if ($kAnimal == "Cattle-Draft") {
        echo "selected";
    }
    ?>>Cattle Draft</option>
		<option value="Catte-Dairy"<?PHP if ($kAnimal == "Catte-Dairy") {
        echo "selected";
    }
    ?>>Cattle Dairy</option>
		<option value="Cattle-Fattener"<?PHP if ($kAnimal == "Cattle-Fattener") {
        echo "selected";
    }
    ?>>Cattle Fattener</option>
		<option value="--------">---------</option>
		<option value="Horse-Draft"<?PHP if ($kAnimal == "Horse-Draft") {
        echo "selected";
    }
    ?>>Horse Draft</option>
		<option value="Horse-Working"<?PHP if ($kAnimal == "Horse-Working") {
        echo "selected";
    }
    ?>>Horse Working</option>
		<option value="Horse-Breeder"<?PHP if ($kAnimal == "Horse-Breeder") {
        echo "selected";
    }
    ?>>Horse Breeder</option>
		<option value="--------">---------</option>
		<option value="Swine-Fattener"<?PHP if ($kAnimal == "Swine-Fattener") {
        echo "selected";
    }
    ?>>Swine Fattener</option>
		<option value="Swine-Breeder"<?PHP if ($kAnimal == "Swine-Breeder") {
        echo "selected";
    }
    ?>>Swine Breeder</option>
		<option value="--------">---------</option>
		<option value="Goat-Fattener"<?PHP if ($kAnimal == "Goat-Fattener") {
        echo "selected";
    }
    ?>>Goat Fattener</option>
		<option value="Goat-Breeder"<?PHP if ($kAnimal == "Goat-Breeder") {
        echo "selected";
    }
    ?>>Goat Breeder</option>
		<option value="Goat-Milking"<?PHP if ($kAnimal == "Goat-Milking") {
        echo "selected";
    }
    ?>>Goat Milking</option>
		<option value="--------">---------</option>
		<option value="Sheep-Fattener"<?PHP if ($kAnimal == "Sheep-Fattener") {
        echo "selected";
    }
    ?>>Sheep Fattener</option>
		<option value="Sheep-Breeder"<?PHP if ($kAnimal == "Sheep-Breeder") {
        echo "selected";
    }
    ?>>Sheep Breeder</option>
		<option value="--------">---------</option>
		<option value="Poultry-Broilers"<?PHP if ($kAnimal == "Poultry-Broilers") {
        echo "selected";
    }
    ?>>Poultry-Broilers</option>
		<option value="Poultry-Pullets"<?PHP if ($kAnimal == "Poultry-Pullets") {
        echo "selected";
    }
    ?>>Poultry-Pullets</option>
		<option value="Poultry-Layers"<?PHP if ($kAnimal == "Poultry-Layers") {
        echo "selected";
    }
    ?>>Poultry-Layers</option>
	</select>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="tag">COLC / COTC / TAG</label>
			</th>
		<td>
			<input type="text" name="tag" class="form-control form-control-sm" value="<?php echo $tag; ?>" readonly>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="rate">Premium Rate</label>
			</th>
		<td>
			<input type="number" min=0 step="any" name ="rate" id ="rate" required value="<?PHP echo $rate; ?>" placeholder="0.00" class="form-control form-control-sm">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="cover">Amount Cover</label>
			</th>
		<td>
			<input type="number" min=0 step="any" name="cover" id ="cover" required value="<?PHP echo $aCover; ?>" placeholder="0.00" class="form-control form-control-sm" readonly>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="effectivity-date" >FROM:</label>
			</th>
		<td>
			<input type="date" id="effectivity-date" name="effectivity-date"  value="<?PHP echo $from; ?>" class="form-control form-control-sm" readonly>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="expiry-date">TO: </label>
			</th>
		<td>
			<input type="date" id="expiry-date" name="expiry-date"  value="<?PHP echo $to; ?>" class="form-control form-control-sm" readonly>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="fileUpload" >Application:</label>
			</th>
		<td>
			<input type="file" id="fileUpload" name="fileUpload" readonly>
	<?php if (!empty($application_form) && file_exists('uploads/RSBSA/' . $ids . 'RSBSA.pdf')) {
        echo '<small>Application file already exists.</small>';
    } else {
    }?>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="loading">PREMIUM LOADING</label>
			</th>
		<td>
			<textarea id="loading" name="loading" class="form-control form-control-sm" readonly><?php echo $prem_loading; ?></textarea>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="iu" >IU/Solicitor</label>
			</th>
		<td>
			<input type="text" id="iu" name="iu" class="form-control form-control-sm" value="<?php echo $iu; ?>" readonly>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="notes">Notes:</label>
		</th>
			<td>
				<textarea name="notes" id="notes" maxlength="1000" class="form-control form-control-sm"><?PHP echo $notes; ?></textarea>
			</td>
	</tr>
</table>

<input type="hidden" id="ids" name="ids" value="<?PHP echo $ids; ?>" class="form-control form-control-sm" readonly>



<?php

}
# end if evaluated

else {
    ?>

<table class="table table-sm table-condensed">
	<tr>
		<th scope="row"><label for="lslb">Logbook No.:</label></th>
		<td><input type="number" id="lslb" name="lslb" value="<?PHP echo $logbook; ?>" step="any" min=0 class="form-control form-control-sm" autofocus></td>
	</tr>
	<?php
if ($_SESSION['stat'] == 'Main') {
        ?>
		<th scope="row">
			<label for="stt">Status:</label>
			</th>
				<td>
					<select name="stt" id="stt" class="form-control form-control-sm" >
						<option value="active"<?PHP if ($stats == "active") {
            echo "selected";
        }
        ?>>Active</option>
						<option value="cancelled"<?PHP if ($stats == "cancelled") {
            echo "selected";
        }
        ?>>Cancelled</option>
						<option value="evaluated"<?PHP if ($stats == "evaluated") {
            echo "selected";
        }
        ?>>Evaluated</option>
						<option value="hold"<?PHP if ($stats == "hold") {
            echo "selected";
        }
        ?>>Hold</option>
					</select>
				</td>
		<?php

    } else {
        ?>
		<th scope="row">
			<label for="stt">Status:</label>
			</th>
				<td>
					<select name="stt" id="stt" class="form-control form-control-sm" readonly>
						<option value="active"<?PHP if ($stats == "active") {
            echo "selected";
        }
        ?>>Active</option>
						<option value="cancelled"<?PHP if ($stats == "cancelled") {
            echo "selected";
        }
        ?>>Cancelled</option>
						<option value="evaluated"<?PHP if ($stats == "evaluated") {
            echo "selected";
        }
        ?>>Evaluated</option>
						<option value="hold"<?PHP if ($stats == "hold") {
            echo "selected";
        }
        ?>>Hold</option>
					</select>
				</td>
		<?php
}
    ?>
	<tr>
		<th scope="row"><label for="group-name">Group Name: </label></th>
		<td><input type="text" name="group-name" id="group-name" placeholder="DA/LGU or et. al." required maxlength="200" value="<?PHP echo $group; ?>" class="form-control form-control-sm"></td>
	</tr>
	<tr>
			<th scope="row"><label for="type_rsbsa">Type of RSBSA (optional): </label></th>
			<td>
                <select id="type_rsbsa" name="type_rsbsa" class="form-control form-control-sm">
                   <option value="PPPP" <?php if ($rsbsa_type == 'PPPP') {echo "selected";}?>>Default</option>
                   <option value="PPPP-ARB" <?php if ($rsbsa_type == 'PPPP-ARB') {echo "selected";}?>>DAR</option>
                </select>
            </td>
		</tr>
	<tr>
		<th scope="row"><label for="assured-name" >Name of Assured:</label></th>
		<td><input type="text" name="assured-name" id="assured-name" placeholder="Juan Dela Cruz et. al." required maxlength="200" value="<?PHP echo $assured; ?>" class="form-control form-control-sm"></td>
	</tr>
	<tr>
		<th scope="row"><label for="address" >Province</label></th>
		<td><select id="province" name="province" placeholder="Leyte" class="form-control form-control-sm">
		<option value="Leyte" <?php if ($province == "LEYTE") {
        echo "selected";
    }?>>LEYTE</option>
		<option value="Southern Leyte" <?php if ($province == "SOUTHERN LEYTE") {
        echo "selected";
    }?>>SOUTHERN LEYTE</option>
		<option value="Biliran" <?php if ($province == "BILIRAN") {
        echo "selected";
    }?>>BILIRAN</option>
		<option value="Northern Samar" <?php if ($province == "NORTHERN SAMAR") {
        echo "selected";
    }?>>NORTHERN SAMAR</option>
		<option value="Eastern Samar" <?php if ($province == "EASTERN SAMAR") {
        echo "selected";
    }?>>EASTERN SAMAR</option>
		<option value="Western Samar" <?php if ($province == "WESTERN SAMAR") {
        echo "selected";
    }?>>WESTERN SAMAR</option>
	</select></td>
	</tr>
	<tr>
		<th scope="row">
			<label for="address" >Town</label>
			</th>
		<td>
			<input type="text" id="town" name="town" placeholder="Abuyog" required maxlength="200"  value="<?PHP echo $town; ?>" class="form-control form-control-sm">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="farmer-count">Farmers</label>
			</th>
		<td>
			<input type="number" id="farmer-count" name="farmer-count" required  min=0 step="any"  value="<?PHP echo $fCount; ?>" class="form-control form-control-sm">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="head-count">Heads</label>
			</th>
		<td>
			<input type="number" id="head-count" name="head-count" required  min=0 step="any" value="<?PHP echo $hCount; ?>" class="form-control form-control-sm">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="animal-type">Kind of Animal</label>
			</th>
		<td>
			<select id="animal-type" name="animal-type" class="form-control form-control-sm">
		<option value="--------">---------</option>
		<option value="Carabao-Breeder"<?PHP if ($kAnimal == "Carabao-Breeder") {
        echo "selected";
    }
    ?>>Carabao Breeder</option>
		<option value="Carabao-Draft"<?PHP if ($kAnimal == "Carabao-Draft") {
        echo "selected";
    }
    ?>>Carabao Draft</option>
		<option value="Carabao-Dairy"<?PHP if ($kAnimal == "Carabao-Dairy") {
        echo "selected";
    }
    ?>>Carabao Dairy</option>
		<option value="Carabao-Fattener"<?PHP if ($kAnimal == "Carabao-Fattener") {
        echo "selected";
    }
    ?>>Carabao Fattener</option>
		<option value="--------">---------</option>
		<option value="Cattle-Breeder"<?PHP if ($kAnimal == "Cattle-Breeder") {
        echo "selected";
    }
    ?>>Cattle Breeder</option>
		<option value="Cattle-Draft"<?PHP if ($kAnimal == "Cattle-Draft") {
        echo "selected";
    }
    ?>>Cattle Draft</option>
		<option value="Catte-Dairy"<?PHP if ($kAnimal == "Catte-Dairy") {
        echo "selected";
    }
    ?>>Cattle Dairy</option>
		<option value="Cattle-Fattener"<?PHP if ($kAnimal == "Cattle-Fattener") {
        echo "selected";
    }
    ?>>Cattle Fattener</option>
		<option value="--------">---------</option>
		<option value="Horse-Draft"<?PHP if ($kAnimal == "Horse-Draft") {
        echo "selected";
    }
    ?>>Horse Draft</option>
		<option value="Horse-Working"<?PHP if ($kAnimal == "Horse-Working") {
        echo "selected";
    }
    ?>>Horse Working</option>
		<option value="Horse-Breeder"<?PHP if ($kAnimal == "Horse-Breeder") {
        echo "selected";
    }
    ?>>Horse Breeder</option>
		<option value="--------">---------</option>
		<option value="Swine-Fattener"<?PHP if ($kAnimal == "Swine-Fattener") {
        echo "selected";
    }
    ?>>Swine Fattener</option>
		<option value="Swine-Breeder"<?PHP if ($kAnimal == "Swine-Breeder") {
        echo "selected";
    }
    ?>>Swine Breeder</option>
		<option value="--------">---------</option>
		<option value="Goat-Fattener"<?PHP if ($kAnimal == "Goat-Fattener") {
        echo "selected";
    }
    ?>>Goat Fattener</option>
		<option value="Goat-Breeder"<?PHP if ($kAnimal == "Goat-Breeder") {
        echo "selected";
    }
    ?>>Goat Breeder</option>
		<option value="Goat-Milking"<?PHP if ($kAnimal == "Goat-Milking") {
        echo "selected";
    }
    ?>>Goat Milking</option>
		<option value="--------">---------</option>
		<option value="Sheep-Fattener"<?PHP if ($kAnimal == "Sheep-Fattener") {
        echo "selected";
    }
    ?>>Sheep Fattener</option>
		<option value="Sheep-Breeder"<?PHP if ($kAnimal == "Sheep-Breeder") {
        echo "selected";
    }
    ?>>Sheep Breeder</option>
		<option value="--------">---------</option>
		<option value="Poultry-Broilers"<?PHP if ($kAnimal == "Poultry-Broilers") {
        echo "selected";
    }
    ?>>Poultry-Broilers</option>
		<option value="Poultry-Pullets"<?PHP if ($kAnimal == "Poultry-Pullets") {
        echo "selected";
    }
    ?>>Poultry-Pullets</option>
		<option value="Poultry-Layers"<?PHP if ($kAnimal == "Poultry-Layers") {
        echo "selected";
    }
    ?>>Poultry-Layers</option>
	</select>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="tag">COLC / COTC / TAG</label>
			</th>
		<td>
			<input type="text" name="tag" class="form-control form-control-sm" value="<?php echo $tag; ?>" >
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="rate">Premium Rate</label>
			</th>
		<td>
			<input type="number" min=0 step="any" name ="rate" id ="rate" required value="<?PHP echo $rate; ?>" placeholder="0.00" class="form-control form-control-sm">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="cover">Amount Cover</label>
			</th>
		<td>
			<input type="number" min=0 step="any" name="cover" id ="cover" required value="<?PHP echo $aCover; ?>" placeholder="0.00" class="form-control form-control-sm">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="effectivity-date" >FROM:</label>
			</th>
		<td>
			<input type="date" id="effectivity-date" name="effectivity-date"  value="<?PHP echo $from; ?>" class="form-control form-control-sm">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="expiry-date">TO: </label>
			</th>
		<td>
			<input type="date" id="expiry-date" name="expiry-date"  value="<?PHP echo $to; ?>" class="form-control form-control-sm">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="fileUpload" >Application:</label>
			</th>
		<td>
			<input type="file" id="fileUpload" name="fileUpload">
	<?php if (!empty($application_form) && file_exists('uploads/RSBSA/' . $ids . 'RSBSA.pdf')) {
        echo '<small>Application file already exists.</small>';
    } else {
    }?>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="loading">PREMIUM LOADING</label>
			</th>
		<td>
			<textarea id="loading" name="loading" class="form-control form-control-sm"><?php echo $prem_loading; ?></textarea>
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="iu" >IU/Solicitor</label>
			</th>
		<td>
			<input type="text" id="iu" name="iu" class="form-control form-control-sm" value="<?php echo $iu; ?>">
			</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="notes">Notes:</label>
		</th>
			<td>
				<textarea name="notes" id="notes" maxlength="1000" class="form-control form-control-sm"><?PHP echo $notes; ?></textarea>
			</td>
	</tr>
</table>

<input type="hidden" id="assured-id" name="assured-id" value="<?PHP echo $f_id; ?>" class="form-control form-control-sm" readonly>
<input type="hidden" id="ids" name="ids" value="<?PHP echo $ids; ?>" class="form-control form-control-sm" readonly>

<?php

}
?>

