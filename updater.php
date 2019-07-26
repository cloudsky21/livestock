<?PHP
session_start();
include("connection/conn.php");
$table = "controlr";

$ids = htmlentities($_POST['rowid']);
$result = $db->prepare("SELECT * FROM $table WHERE idsnumber = ?");
$result->execute([$ids]);
foreach ($result as $row){
	
	$group = $row['groupName'];
	$rcNumber = $row['receiptNumber'];
	$rcAmount = $row['receiptAmt'];
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
	$logbook = $row['lslb'];
	$s_charge = $row['s_charge'];
	$iu = $row['iu'];

	$application_form = $row['imagepath'];
}



?>



<div class="form-group">
	<label for="group-name" class="control-label col-sm-4">Group Name / Lending Institution</label>
	<div class="col-sm-8">	
		<input type="text" id="group-name" name="group-name" placeholder="DA/LGU or et. al." required maxlength="200" value="<?PHP echo $group; ?>" class="form-control">
	</div>
</div>

<div class="form-group">
	<label for="assured-name" class="control-label col-sm-4">Name of Assured</label>
	<div class="col-sm-8">
		<input type="text" id="assured-name" name="assured-name" id="assured-name" placeholder="Juan Dela Cruz et. al." required maxlength="200" value="<?PHP echo $assured; ?>"  class="form-control">
	</div>
</div>

<div class="form-group">
	<label for="address" class="control-label col-sm-4">Province</label>
	<div class="col-sm-8">
		<select id="province" name="province" placeholder="Leyte" class="form-control">
			<option value="Leyte" <?php if($province == "LEYTE"){ echo "selected";} ?>>LEYTE</option>
			<option value="Southern Leyte" <?php if($province == "SOUTHERN LEYTE"){ echo "selected";} ?>>SOUTHERN LEYTE</option>
			<option value="Biliran" <?php if($province == "BILIRAN"){ echo "selected";} ?>>BILIRAN</option>
			<option value="Northern Samar" <?php if($province == "NORTHERN SAMAR"){ echo "selected";} ?>>NORTHERN SAMAR</option>
			<option value="Eastern Samar" <?php if($province == "EASTERN SAMAR"){ echo "selected";} ?>>EASTERN SAMAR</option>
			<option value="Western Samar" <?php if($province == "WESTERN SAMAR"){ echo "selected";} ?>>WESTERN SAMAR</option>
		</select>
	</div>
</div>
</div>

<div class="form-group">
	<label for="address" class="control-label col-sm-4">Town</label>
	<div class="col-sm-8">
		<input type="text" id="town" name="town" placeholder="Abuyoge" required maxlength="200"  value="<?PHP echo $town; ?>" class="form-control">
	</div>
</div>
</div>


<div class="form-group">			
	<label for="farmer-count" class="control-label col-sm-4">Farmers</label>
	<div class="col-sm-8">
		<input type="number" id="farmer-count" name="farmer-count" required  min=0 step="any"  value="<?PHP echo $fCount; ?>"  class="form-control">
	</div>
</div>

<div class="form-group">
	<label for="head-count" class="control-label col-sm-4">Heads</label>
	<div class="col-sm-8">
		<input type="number" id="head-count" name="head-count" required  min=0 step="any" value="<?PHP echo $hCount; ?>"  class="form-control">
	</div>
</div>




<div class="form-group">
	<label for="animal-type" class="control-label col-sm-4">Kind of Animal</label>
	<div class="col-sm-8">
		<select name="animal-type" id="animal-type" onchange="getch(this.value);" class="form-control">
			<option value="--------">---------</option>
			<option value="Carabao-Breeder"<?PHP if($kAnimal== "Carabao-Breeder") echo "selected" ?>>Carabao Breeder</option>
			<option value="Carabao-Draft"<?PHP if($kAnimal== "Carabao-Draft") echo "selected" ?>>Carabao Draft</option>
			<option value="Carabao-Dairy"<?PHP if($kAnimal== "Carabao-Dairy") echo "selected" ?>>Carabao Dairy</option>
			<option value="Carabao-Fattener"<?PHP if($kAnimal== "Carabao-Fattener") echo "selected" ?>>Carabao Fattener</option>
			<option value="--------">---------</option>
			<option value="Cattle-Breeder"<?PHP if($kAnimal== "Cattle-Breeder") echo "selected" ?>>Cattle Breeder</option>
			<option value="Cattle-Draft"<?PHP if($kAnimal== "Cattle-Draft") echo "selected" ?>>Cattle Draft</option>
			<option value="Catte-Dairy"<?PHP if($kAnimal== "Catte-Dairy") echo "selected" ?>>Cattle Dairy</option>
			<option value="Cattle-Fattener"<?PHP if($kAnimal== "Cattle-Fattener") echo "selected" ?>>Cattle Fattener</option>
			<option value="--------">---------</option>
			<option value="Horse-Draft"<?PHP if($kAnimal== "Horse-Draft") echo "selected" ?>>Horse Draft</option>
			<option value="Horse-Working"<?PHP if($kAnimal== "Horse-Working") echo "selected" ?>>Horse Working</option>
			<option value="Horse-Breeder"<?PHP if($kAnimal== "Horse-Breeder") echo "selected" ?>>Horse Breeder</option>
			<option value="--------">---------</option>
			<option value="Swine-Fattener"<?PHP if($kAnimal== "Swine-Fattener") echo "selected" ?>>Swine Fattener</option>
			<option value="Swine-Breeder"<?PHP if($kAnimal== "Swine-Breeder") echo "selected" ?>>Swine Breeder</option>
			<option value="--------">---------</option>
			<option value="Goat-Fattener"<?PHP if($kAnimal== "Goat-Fattener") echo "selected" ?>>Goat Fattener</option>
			<option value="Goat-Breeder"<?PHP if($kAnimal== "Goat-Breeder") echo "selected" ?>>Goat Breeder</option>
			<option value="--------">---------</option>
			<option value="Sheep-Fattener"<?PHP if($kAnimal== "Sheep-Fattener") echo "selected" ?>>Sheep Fattener</option>
			<option value="Sheep-Breeder"<?PHP if($kAnimal== "Sheep-Breeder") echo "selected" ?>>Sheep Breeder</option>
			<option value="--------">---------</option>
			<option value="Poultry-Broilers"<?PHP if($kAnimal== "Poultry-Broilers") echo "selected" ?>>Poultry-Broilers</option>
			<option value="Poultry-Pullets"<?PHP if($kAnimal== "Poultry-Pullets") echo "selected" ?>>Poultry-Pullets</option>
			<option value="Poultry-Layers"<?PHP if($kAnimal== "Poultry-Layers") echo "selected" ?>>Poultry-Layers</option>
		</select>
	</div>
</div>

<div class="form-group">	
	<label for="rate" class="control-label col-sm-4">Premium Rate</label>
	<div class="col-sm-8">
		<input type="number" min=0 step="any" name ="rate" id ="rate" required value="<?PHP echo $rate; ?>" placeholder="0.00" class="form-control">
	</div>
</div>	


<div class="form-group row">
	<label for="cover" class="control-label col-sm-4">Amount Cover</label>
	<div class="col-sm-8">
		<input type="number" min=0 step="any" name="cover" id ="cover" required value="<?PHP echo $aCover; ?>" placeholder="0.00" class="form-control">
	</div>
</div>	
<?PHP if($rate == "1.7"){ ?>

<div class="form-group">
	<label for="effectivity-date" class="control-label col-sm-4">FROM:</label>
	<div class="col-sm-8">
		<input type="date" name="effectivity-date"  value="<?PHP echo $from; ?>" class="form-control">
	</div>
</div>

<div class="form-group">
	<label for="expiry-date" class="control-label col-sm-4">TO:</label>
	<div class="col-sm-8">
		<input type="date" name="expiry-date"  value="<?PHP echo $to; ?>" class="form-control">
	</div>
</div>


<div class="form-group">
	<label for="effectivity-date" class="control-label col-sm-4">FROM:</label>
	<div class="col-sm-8">
		<input type="date" name="effectivity-date"  value="<?PHP echo $from; ?>" class="form-control">
	</div>
</div>

<div class="form-group">
	<label for="expiry-date" class="control-label col-sm-4">TO:</label>
	<div class="col-sm-8">
		<input type="date" name="expiry-date"  value="<?PHP echo $to; ?>" class="form-control">
	</div>
</div>

<div class="form-group">
	<label for="effectivity-date" class="control-label col-sm-4">FROM:</label>
	<div class="col-sm-8">
		<input type="date" name="effectivity-date"  value="<?PHP echo $from; ?>" class="form-control">
	</div>
</div>

<div class="form-group">
	<label for="expiry-date" class="control-label col-sm-4">TO:</label>
	<div class="col-sm-8">
		<input type="date" name="expiry-date"  value="<?PHP echo $to; ?>" class="form-control">
	</div>
</div>



<?PHP } else { ?>

<div class="form-group">	
	<label for="effectivity-date" class="control-label col-sm-4">FROM:</label>
	<div class="col-sm-8">
		<input type="date" name="effectivity-date"  value="<?PHP echo $from; ?>" class="form-control">
	</div>
</div>

<div class="form-group">
	<label for="expiry-date" class="control-label col-sm-4">TO:</label>
	<div class="col-sm-8">
		<input type="date" name="expiry-date"  value="<?PHP echo $to; ?>" class="form-control">
	</div>
</div>


<?PHP } ?>

<div class="form-group">		
	<label for="stt" class="control-label col-sm-4">Status:</label>
	<div class="col-sm-8">
		<select name="stt" id="stt" id="stt" class="form-control">
			<option value="active"<?PHP if($stats== "active") echo "selected" ?>>Active</option>
			<option value="cancelled"<?PHP if($stats== "cancelled") echo "selected" ?>>Cancelled</option>
		</select>
	</div>
</div>



<div class="form-group">
	<label for="rcnum" class="control-label col-sm-4">Receipt No.</label>
	<div class="col-sm-8">
		<input type="number" id="rcnum" name="rcnum" tabindex="2" placeholder="0000000" value="<?PHP echo $rcNumber; ?>" required step="any" class="form-control">
	</div>
</div>	

<div class="form-group">
	<label for="rcAmt" class="control-label col-sm-4">Receipt Amount</label>
	<div class="col-sm-8">
		<input type="number" id="rcAmt" name="rcAmt" tabindex="3" placeholder="0000" value="<?PHP echo $rcAmount; ?>" required step="any" class="form-control">
	</div>
</div>


	<div class="form-group">
		<label for="scharge" class="control-label col-sm-4">Service Charge</label>
		<div class="col-sm-8">
			<input type="number" id="scharge" name="scharge" tabindex="4" placeholder="0000" value="<?PHP echo $s_charge; ?>" step="any" class="form-control">
		</div>
	</div>

	<div class="form-group">	
		<label for="fileUpload" class="control-label col-sm-4">Application:</label>
		<div class="col-sm-8">
			<input type="file" id="fileUpload" name="fileUpload">
			<?php if(!empty($application_form) && file_exists('uploads/'.$ids.'REGULAR.pdf')) {echo '<small>Application file already exists.</small>';} else {} ?>
		</div>
	</div>
	<div class="form-group">	
		<label for="iu" class="control-label col-sm-4">IU/Solicitor</label>
		<div class="col-sm-8">
			<input type="text" id="iu" name="iu" class="form-control" value="<?php echo $iu ?>">			
		</div>
	</div>

	<div class="form-group">
		<label for="lslb" class="control-label col-sm-4">Logbook No.:</label>
		<div class="col-sm-8">
			<?PHP if($logbook == " "){ echo '<input type="number" id="lslb" name="lslb" step="any" min=0 class="form-control">';} else {echo '<input type="number" id="lslb" name="lslb" value="'.$logbook.'" step="any" min=0 class="form-control">'; } ?>
		</div>
	</div>




	<input type="hidden" id="ids" name="ids" value="<?PHP echo $ids; ?>" class="form-control">


