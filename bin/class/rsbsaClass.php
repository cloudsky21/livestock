<?php
class Rsbsa {

	Public function insertData($db,$values,$table)
	{
		$columns = array(
			"Year","date_r","program","groupName",
			"ids1","lsp","province","town","assured",
			"farmers","heads","animal","premium",
			"amount_cover","rate","Dfrom",
			"Dto","status","office_assignment",
			"loading","iu","prepared"
		);

		$placeholders = substr(str_repeat('?,', sizeOf($columns)), 0, -1);

		$result = $db->prepare(
			sprintf(
				"INSERT INTO %s (%s) VALUES (%s)", 
				$table, 
				implode(',', $columns), 
				$placeholders
			)
		);

		$result->execute($values);
		return $result->rowCount();


	}
	Public function getDate($date)
	{
		if($date == '1970-01-01')
		{
			$date = date("Y-m-d");
		}
		else {
			$date = date("Y-m-d", strtotime($date));
		}
		return $date;
	}
	public function lsp($animal)
	{
		if($animal=="Carabao-Breeder" || $animal=="Carabao-Draft" || $animal=="Carabao-Dairy" || $animal=="Carabao-Fattener"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'], -2)."-"."WB-";
		}
		else if($animal=="Cattle-Breeder" || $animal=="Cattle-Draft" || $animal=="Cattle-Dairy" || $animal=="Cattle-Fattener"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."CA-";
		}
		else if($animal=="Horse-Breeder" || $animal=="Horse-Draft" || $animal=="Horse-Working"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."HO-";	
		}
		else if($animal=="Swine-Breeder"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SB-";	
		}
		else if($animal=="Swine-Fattener"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SF-";	
		}
		else if($animal=="Sheep-Fattener" || $animal=="Sheep-Breeder"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SH-";	
		}
		else if($animal=="Poultry-Broilers"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PM-";	
		}
		else if($animal=="Poultry-Layers" || $animal=="Poultry-Pullets"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PE-";	
		}
		else if($animal=="Goat-Breeder" || $animal=="Goat-Fattener" || $animal == "Goat-Milking"){

			$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."GO-";
		}
		return $LSP;
	}

	public function office_assignment($peo, $town)
	{

		if($peo == "BILIRAN")
		{
			$office = "PEO Biliran";
		}
		elseif ($peo == "LEYTE") {
			// Check if what district
			switch ($town) {
				case 'TACLOBAN CITY':
					# code...
				$office = "Leyte1-2";
				break;

				case 'ALANGALANG':
					# code...
				$office = "Leyte1-2";
				break;

				case 'BABATNGON':
					# code...
				$office = "Leyte1-2";
				break;

				case 'PALO':
					# code...
				$office = "Leyte1-2";
				break;

				case 'SAN MIGUEL':
					# code...
				$office = "Leyte1-2";
				break;

				case 'SANTA FE':
					# code...
				$office = "Leyte1-2";
				break;

				case 'STA. FE':
					# code...
				$office = "Leyte1-2";
				break;

				case 'TANAUAN':
					# code...
				$office = "Leyte1-2";
				break;

				case 'TOLOSA':
					# code...
				$office = "Leyte1-2";
				break;

				case 'BARUGO':
					# code...
				$office = "Leyte1-2";
				break;

				case 'BURAUEN':
					# code...
				$office = "Leyte1-2";
				break;

				case 'CAPOOCAN':
					# code...
				$office = "Leyte1-2";
				break;

				case 'CARIGARA':
					# code...
				$office = "Leyte1-2";
				break;

				case 'DAGAMI':
					# code...
				$office = "Leyte1-2";
				break;

				case 'DULAG':
					# code...
				$office = "Leyte1-2";
				break;

				case 'JARO':
					# code...
				$office = "Leyte1-2";
				break;

				case 'JULITA':
					# code...
				$office = "Leyte1-2";
				break;

				case 'LA PAZ':
					# code...
				$office = "Leyte1-2";
				break;

				case 'PASTRANA':
					# code...
				$office = "Leyte1-2";
				break;

				case 'TABONTABON':
					# code...
				$office = "Leyte1-2";
				break;

				case 'TUNGA':
					# code...
				$office = "Leyte1-2";
				break;

				case 'CALUBIAN':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'LEYTE':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'SAN ISIDRO':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'TABANGO':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'VILLABA':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'ORMOC CITY':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'ALBUERA':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'ISABEL':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'KANANGA':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'MATAG-OB':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'MERIDA':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'PALOMPON':
					# code...
				$office = "PEO Ormoc";
				break;

				case 'BAYBAY CITY':
					# code...
				$office = "PEO Abuyog";
				break;

				case 'ABUYOG':
					# code...
				$office = "PEO Abuyog";
				break;

				case 'BATO':
					# code...
				$office = "PEO Abuyog";
				break;

				case 'HILONGOS':
					# code...
				$office = "PEO Abuyog";
				break;

				case 'HINDANG':
					# code...
				$office = "PEO Abuyog";
				break;

				case 'INOPACAN':
					# code...
				$office = "PEO Abuyog";
				break;

				case 'JAVIER':
					# code...
				$office = "PEO Abuyog";
				break;

				case 'MAHAPLAG':
					# code...
				$office = "PEO Abuyog";
				break;

				case 'MATALOM':
					# code...
				$office = "PEO Abuyog";
				break;
				
			}
		}
		elseif($peo == "NORTHERN SAMAR")
		{
			$office = "PEO N-Samar";
		}
		elseif($peo == "WESTERN SAMAR")
		{
			$office = "PEO W-Samar";
		}
		elseif($peo == "EASTERN SAMAR")
		{
			$office = "PEO E-Samar";
		}
		else
		{
			$office = "PEO Sogod";
		}

		return $office;
	}
}



?>