<?php

namespace Classes;

class monitoring
{

    private $db;
    private $table;
    public function __construct($table, $db)
    {


        $this->db = $db;
        $this->table = $table;
    }

    public function insertData($values)
    {

        $table = $this->table;
        $db = $this->db;
        $columns = array(
            "year", "total", "date_received", "date_added", "sender"
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


    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }
} // END Class