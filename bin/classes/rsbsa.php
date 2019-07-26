<?php

namespace Classes;

class Rsbsa
{

    private $db;
    private $table;
    public function __construct($table)
    {

        require '../connection/conn.php';
        $this->db = $db;
        $this->table = $table;

    }
    public static function longTitle()
    {
        $title = "Registry System on Basic Sectors in Agriculture (RSBSA)";
        return $title;
    }
    public static function shortTitle()
    {
        $title = "rsbsa";
        return $title;
    }

    public function insertData($values)
    {

        $table = $this->table;
        $db = $this->db;
        $columns = array(
            "Year", "date_r", "program", "groupName", "ids1", "lsp", "province", "town", "assured",
            "farmers", "heads", "animal", "premium", "amount_cover", "rate", "Dfrom", "Dto", "status", "office_assignment",
            "loading", "iu", "prepared", "tag", "f_id", "comments", "idsprogram",
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
        $inserted_id = $db->lastInsertId();
        return $result->rowCount();

    }
    public function getDate($date)
    {
        if ($date == '1970-01-01') {
            $date = date("Y-m-d");
        } else {
            $date = date("Y-m-d H:i:s", strtotime($date));
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

                case 'TACLOBAN':
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

    public function update($values)
    {

        /* $group, $assured, $province, $town, $_POST['farmer-count'], $_POST['head-count'], $_POST['animal-type'], $LSP,
        $bpremium, $_POST['rate'], $_POST['cover'], $fromDate,    $toDate, $_POST['stt'],    $_lslb,    $office_assignment,    $prem_loading,
        $iu, $_POST['ids'] */

        $table = $this->table;
        $db = $this->db;
        $rs = $db->prepare("UPDATE $table SET
			groupName=?,
            assured=?,
            province=?,
            town=?,
            farmers=?,
            heads=?,
            animal=?,
            lsp=?,
            premium=?,
            rate=?,
            amount_cover=?,
            Dfrom=?,
            Dto=?,
            status=?,
            lslb=?,
            office_assignment = ?,
            loading = ?,
            iu=?,
            tag=?,
            f_id= ?,
            comments =?,
            idsprogram = ? WHERE idsnumber=?");

        $rs->execute($values);

        return $rs->rowCount();
    }

    public static function prem_loading($animal, $r_date)
    {
        $s_date = "2018-12-01";
        $e_date = "2019-02-28";

        if ($r_date >= $s_date && $r_date <= $e_date) {
            /*
            /^[1-9][0-9]{0,15}$/
             */
            if (preg_match('/\b(\w*Swine\w*)\b/', $animal, $matches)) {
                $premLoading = "salmonellosis-0.25,Hog Cholera-0.50,HMD-0.25";
            } elseif (preg_match('/\b(\w*Carabao\w*)\b/', $animal, $matches)) {
                $premLoading = "HMD-0.25,BLACK LEG-0.25,HEM. SEPTECIMIA-0.25";
            } elseif (preg_match('/\b(\w*Cattle\w*)\b/', $animal, $matches)) {
                $premLoading = "HMD-0.25,BLACK LEG-0.25,HEM. SEPTECIMIA-0.25";
            } elseif (preg_match('/\b(\w*Horse\w*)\b/', $animal, $matches)) {
                $premLoading = "HMD-0.25,BLACK LEG-0.25,HEM. SEPTECIMIA-0.25";
            }

        } else if ($r_date >= $e_date) {

            if (preg_match('/\b(\w*Swine\w*)\b/', $animal, $matches)) {
                $premLoading = "All types of disease covered.";
            } elseif (preg_match('/\b(\w*Carabao\w*)\b/', $animal, $matches)) {
                $premLoading = "All types of disease covered.";
            } elseif (preg_match('/\b(\w*Cattle\w*)\b/', $animal, $matches)) {
                $premLoading = "All types of disease covered.";
            } elseif (preg_match('/\b(\w*Horse\w*)\b/', $animal, $matches)) {
                $premLoading = "All types of disease covered.";
            }
        } else {
            $premLoading = "";
        }

        return $premLoading;

    }

    public function delete($ids, $header)
    {
        $table = $this->table;
        $db = $this->db;
        $result = $db->prepare("DELETE FROM $table WHERE idsnumber = ?");
        $result->execute([$ids]);
        $result = $db->prepare("ALTER TABLE $table AUTO_INCREMENT=1");
        $result->execute();

        header("location:" . $header);

    }

} // END Class