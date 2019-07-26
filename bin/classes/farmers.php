<?php
namespace Classes;

class farmers
{

    public function param($param, $name, $assignment, $province, $town)
    {
        $root = $_SERVER['DOCUMENT_ROOT'] . '/livestock/';
        include $root . 'connection/conn.php';

        $exist = $this->exists($param);

        switch (true) {
            case ($exist == '0'):
                $result = $db->prepare("INSERT INTO farmers (id, name, office_assigned, province, city) VALUES(?,?,?,?,?)");
                $result->execute([$param, $name, $assignment, $province, $town]);
                break;

            default:
                break;
        }

        return $exist;
    }

    public function exists($id)
    {
        $root = $_SERVER['DOCUMENT_ROOT'] . '/livestock/';
        include $root . 'connection/conn.php';

        $result = $db->prepare('SELECT name FROM farmers WHERE id = ? LIMIT 1');
        $result->execute([$id]);

        $count = $result->rowcount();
        return $count;
    }

    public function update($param, $name, $assignment, $province, $town)
    {
        $root = $_SERVER['DOCUMENT_ROOT'] . '/livestock/';
        include $root . 'connection/conn.php';

        $result = $db->prepare('UPDATE farmers SET name = ?, office_assigned = ?, province = ?, city = ? WHERE id = ?');
        $result->execute([$name, $assignment, $province, $town, $param]);

        $count = $result->rowcount();
        return $count;
    }
}