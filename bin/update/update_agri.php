<?PHP
session_start();
require_once("../../connection/conn.php");
if(isset($_POST['rowid'])){
	$ids = htmlentities($_POST['rowid']);
	$table = "agriagra".$_SESSION['insurance'];
	$result = $db->prepare("SELECT * FROM $table WHERE idsnumber = ?");
	$result->execute([$ids]);
	foreach ($result as $row){
		$group = $row['groupName'];
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
		$logbook = ($row['lslb']=='0') ? ' ' : $row['lslb'];
		$prem_loading = $row['loading'];
		$iu = $row['iu'];

		$application_form = $row['imagepath'];
		
	}
}
?>
<div class="form-group">	
	<label for="lslb">Logbook No.:</label>	
	<input type="number" id="lslb" name="lslb" value="<?PHP  echo $logbook;   ?>" step="any" min=0 class="form-control">
	
	
</div>
<div class="form-group">
	<label for="group-name"> Group Name</label>
	
	<input type="text" name="group-name" id="group-name" placeholder="DA/LGU or et. al." required maxlength="200" value="<?PHP echo $group; ?>" class="form-control">
	
</div>
<div class="form-group">
	<label for="assured-name" >Name of Assured</label>
	
	<input type="text" name="assured-name" id="assured-name" placeholder="Juan Dela Cruz et. al." required maxlength="200" value="<?PHP echo $assured; ?>" class="form-control">
	

</div>
<div class="form-group">
	<label for="address" >Province</label>
	
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
<div class="form-group">
	<label for="address" >Town</label>

	<input type="text" id="town" name="town" placeholder="Abuyog" required maxlength="200"  value="<?PHP echo $town; ?>" class="form-control">
	
</div>
</div>
<div class="form-group">		
	<label for="farmer-count">Farmers</label>
	
	<input type="number" id="farmer-count" name="farmer-count" required  min=0 step="any"  value="<?PHP echo $fCount; ?>" class="form-control">
	
</div>
<div class="form-group">
	<label for="head-count">Heads</label>
	
	<input type="number" id="head-count" name="head-count" required  min=0 step="any" value="<?PHP echo $hCount; ?>" class="form-control">
	
</div>
<div class="form-group">
	<label for="animal-type">Kind of Animal</label>
	
	<select id="animal-type" name="animal-type" id="animal-type" onchange="getch(this.value);" class="form-control">
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
		<option value="Goat-Breeder"<?PHP if($kAnimal== "Goat-Milking") echo "selected" ?>>Goat Milking</option>
		<option value="--------">---------</option>
		<option value="Sheep-Fattener"<?PHP if($kAnimal== "Sheep-Fattener") echo "selected" ?>>Sheep Fattener</option>
		<option value="Sheep-Breeder"<?PHP if($kAnimal== "Sheep-Breeder") echo "selected" ?>>Sheep Breeder</option>
		<option value="--------">---------</option>
		<option value="Poultry-Broilers"<?PHP if($kAnimal== "Poultry-Broilers") echo "selected" ?>>Poultry-Broilers</option>
		<option value="Poultry-Pullets"<?PHP if($kAnimal== "Poultry-Pullets") echo "selected" ?>>Poultry-Pullets</option>
		<option value="Poultry-Layers"<?PHP if($kAnimal== "Poultry-Layers") echo "selected" ?>>Poultry-Layers</option>
	</select>
	
</div>	
<div class="form-group">
	<label for="rate">Premium Rate</label>
	
	<input type="number" min=0 step="any" name ="rate" id ="rate" required value="<?PHP echo $rate; ?>" placeholder="0.00" class="form-control">
	
</div>
<div class="form-group">	
	<label for="cover">Amount Cover</label>
	
	<input type="number" min=0 step="any" name="cover" id ="cover" required value="<?PHP echo $aCover; ?>" placeholder="0.00" class="form-control">
	
</div>
<div class="form-group">
	<label for="effectivity-date" >FROM:</label>
	
	<input type="date" id="effectivity-date" name="effectivity-date"  value="<?PHP echo $from; ?>" class="form-control">
	
</div>				
<div class="form-group">
	<label for="expiry-date">TO: </label>
	
	<input type="date" id="expiry-date" name="expiry-date"  value="<?PHP echo $to; ?>" class="form-control">
	
</div>
<div class="form-group">
	<label for="stt">Status:</label>
	
	<select name="stt" id="stt" class="form-control">
		<option value="active"<?PHP if($stats== "active") echo "selected" ?>>Active</option>
		<option value="cancelled"<?PHP if($stats== "cancelled") echo "selected" ?>>Cancelled</option>
	</select>
	
</div>	
<div class="form-group">	
	<label for="fileUpload" >Application:</label>
	
	<input type="file" id="fileUpload" name="fileUpload">
	<?php if(!empty($application_form) && file_exists('uploads/AGRIAGRA/'.$ids.'AGRIAGRA.pdf')) {echo '<small>Application file already exists.</small>';} else {} ?>
	
</div>	

<div class="form-group">	
	<label for="loading">PREMIUM LOADING</label>
	
	<textarea id="loading" name="loading" class="form-control"><?php  echo $prem_loading; ?></textarea>
	
	
</div>
<div class="form-group">	
	<label for="iu" >IU/Solicitor</label>
	
	<input type="text" id="iu" name="iu" class="form-control" value="<?php  echo $iu; ?>">
	
	
</div>

<input type="hidden" id="ids" name="ids" value="<?PHP echo $ids; ?>" class="form-control">