<?php

namespace Classes;

class regular
{

    private $db;
    private $table;

    public function __construct($table)
    {
        include '../connection/conn.php';
        $this->db = $db;
        $this->table = $table;
    }

    public function insertData($values)
    {

        $table = $this->table;
        $db = $this->db;
        $columns_regular = array(
            "Year", "date_r", "receiptNumber", "receiptAmt", "rcd", "groupName", "ids1", "lsp", "province", "town", "assured", "farmers", "heads", "animal", "premium", "rate", "amount_cover",
            "Dfrom", "Dto", "status", "office_assignment", "s_charge", "loading", "iu", "prepared");
        $placeholders = substr(str_repeat('?,', sizeOf($columns_regular)), 0, -1);

        $result = $db->prepare(
            sprintf(
                "INSERT INTO %s (%s) VALUES (%s)",
                $table,
                implode(',', $columns_regular),
                $placeholders
            )
        );

        $result->execute($values);
        return $result->rowcount();

    }

    public function getDate($date)
    {
        if ($date == '1970-01-01') {
            $date = date("Y-m-d");
        } else {
            $date = date("Y-m-d", strtotime($date));
        }
        return $date;
    }

    public function lsp($animal)
    {
        if ($animal == "Carabao-Breeder" || $animal == "Carabao-Draft" || $animal == "Carabao-Dairy" || $animal == "Carabao-Fattener") {
            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "WB-";
        } else if ($animal == "Cattle-Breeder" || $animal == "Cattle-Draft" || $animal == "Cattle-Dairy" || $animal == "Cattle-Fattener") {
            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "CA-";
        } else if ($animal == "Horse-Breeder" || $animal == "Horse-Draft" || $animal == "Horse-Working") {
            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "HO-";
        } else if ($animal == "Swine-Breeder") {
            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "SB-";
        } else if ($animal == "Swine-Fattener") {
            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "SF-";
        } else if ($animal == "Sheep-Fattener" || $animal == "Sheep-Breeder") {
            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "SH-";
        } else if ($animal == "Poultry-Broilers") {
            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "PM-";
        } else if ($animal == "Poultry-Layers" || $animal == "Poultry-Pullets") {
            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "PE-";
        } else if ($animal == "Goat-Breeder" || $animal == "Goat-Fattener" || $animal == "Goat-Milking") {

            $LSP = "LI-RO8-" . substr($_SESSION['insurance'], -2) . "-" . "GO-";
        }
        return $LSP;
    }

    public function office_assignment($peo, $town)
    {

        if ($peo == "BILIRAN") {
            $office = "PEO Ormoc";
        } elseif ($peo == "LEYTE") {
            // Check if what district
            switch ($town) {
                case 'TACLOBAN CITY':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'ALANGALANG':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'BABATNGON':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'PALO':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'SAN MIGUEL':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'SANTA FE':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'STA. FE':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'TANAUAN':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'TOLOSA':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'BARUGO':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'BURAUEN':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'CAPOOCAN':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'CARIGARA':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'DAGAMI':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'DULAG':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'JARO':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'JULITA':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'LA PAZ':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'PASTRANA':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'TABONTABON':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'TUNGA':
                    # code...
                    $office = "PEO TACLOBAN";
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
                    $office = "PEO Ormoc";
                    break;

                case 'ABUYOG':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'BATO':
                    # code...
                    $office = "PEO Ormoc";
                    break;

                case 'HILONGOS':
                    # code...
                    $office = "PEO Ormoc";
                    break;

                case 'HINDANG':
                    # code...
                    $office = "PEO Ormoc";
                    break;

                case 'INOPACAN':
                    # code...
                    $office = "PEO Ormoc";
                    break;

                case 'JAVIER':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'MAHAPLAG':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'MATALOM':
                    # code...
                    $office = "PEO Ormoc";
                    break;

                case 'MAYORGA':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

                case 'MACARTHUR':
                    # code...
                    $office = "PEO TACLOBAN";
                    break;

            }
        } elseif ($peo == "NORTHERN SAMAR") {
            $office = "PEO N-Samar";
        } elseif ($peo == "WESTERN SAMAR") {
            $office = "PEO W-Samar";
        } elseif ($peo == "EASTERN SAMAR") {
            $office = "PEO E-Samar";
        } else {
            $office = "PEO Sogod";
        }

        return $office;

    }

    public function updateData($values)
    {

        $table = $this->table;
        $db = $this->db;
        $result = $db->prepare("UPDATE $table SET
			groupName=?,
			assured=?,
			province=?,
			town=?,
			farmers=?,
			heads=?,
			animal=?,
			premium=?,
			rate=?,
			amount_cover=?,
			Dfrom=?,
			Dto=?,
			status=?,
			receiptNumber=?,
			receiptAmt=?,
			lsp=?,
			lslb=?, office_assignment = ?, s_charge = ?, iu=?, prepared=? WHERE idsnumber=?");

        $result->execute($values);

        return $result->rowcount();

    }
}