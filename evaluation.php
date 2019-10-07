<!DOCTYPE html>

<head>
    <title>EVALUATION</title>
    <style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        font-family: 'consolas';
        font-size: 10pt;
    }

    th,
    td {
        padding: 5px;
    }

    table {
        width: 50%;
    }
    </style>
</head>

<body>

    <?php
    require "connection/conn.php";

    # PEO Sogod
    # PEO E-Samar
    # PEO N-Samar
    # PEO W-Samar



    $peo = 'PEO E-Samar';
    $province = 'BILIRAN';
    $date_1 = '2019-09-19';
    $date_2 = '2019-09-25';


    echo '<table>';

    $result = $db->prepare("SELECT town FROM (SELECT town FROM rsbsa2019 WHERE office_assignment = ? GROUP BY town) As temp_group ORDER BY town ASC");
    #$result = $db->prepare("SELECT town FROM (SELECT town FROM rsbsa2019 WHERE province = ? GROUP BY town) As temp_group ORDER BY town ASC");
    $result->execute([$peo]);

    foreach ($result as $row) {





        foreach ($row as $key => $values) {
            $result = $db->prepare("SELECT SUM(farmers) as Farmers, SUM(heads) as Heads, SUM(amount_cover) as AC, 
SUM(premium) as GPS FROM `rsbsa2019` 
WHERE ((town = ? AND office_assignment = ?) AND status = 'active') AND (date_r BETWEEN ? AND ?)");

            $result->execute([$values, $peo, $date_1, $date_2]);

            foreach ($result as $row) {

                echo '<tr>';
                echo '<td>' . ucwords($values) . '</td>';
                echo '<td>' . $row['Farmers'] . '</td>';
                echo '<td>' . $row['Heads'] . '</td>';
                echo '<td>' . $row['AC'] . '</td>';
                echo '<td>' . $row['GPS'] . '</td>';
                echo '</tr>';
            }
        }
    }
    echo '</table>';

    ?>
</body>

</html>