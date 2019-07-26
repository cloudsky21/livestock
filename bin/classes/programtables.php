<?php

namespace Classes;

class programtables
{

    private $table;
    public function __construct()
    {

    }

    function list() {
        if (isset($_SESSION['token'])) {
            $table = "masterlist";
            return $table;
        } else {
            $this->eject();
        }
    }

    public function rsbsa()
    {
        if (isset($_SESSION['token'])) {
            $table = "rsbsa" . $_SESSION['insurance'];
            return $table;
        } else {
            $this->eject();
        }
    }

    public function acpc()
    {
        if (isset($_SESSION['token'])) {
            $table = "punla" . $_SESSION['insurance'];
            return $table;
        } else {
            $this->eject();
        }
    }

    public function agriagra()
    {
        if (isset($_SESSION['token'])) {
            $table = "agriagra" . $_SESSION['insurance'];
            return $table;
        } else {
            $this->eject();
        }
    }

    public function apcp()
    {
        if (isset($_SESSION['token'])) {
            $table = "apcp" . $_SESSION['insurance'];
            return $table;
        } else {
            $this->eject();
        }
    }

    public function yrrp()
    {
        if (isset($_SESSION['token'])) {
            $table = "yrrp" . $_SESSION['insurance'];
            return $table;
        } else {
            $this->eject();
        }
    }

    public function saad()
    {
        if (isset($_SESSION['token'])) {
            $table = "saad" . $_SESSION['insurance'];
            return $table;
        } else {
            $this->eject();
        }
    }

    public function regular()
    {
        if (isset($_SESSION['token'])) {
            $table = "regular" . $_SESSION['insurance'];
            return $table;
        } else {
            $this->eject();
        }
    }

    public function tableList()
    {
        if (isset($_SESSION['token'])) {
            if ($_SESSION['insurance'] != '2018') {
                $prevYear = $_SESSION['insurance'] - 1;
                $table = array(
                    $this->rsbsa(), $this->agriagra(), $this->regular(), $this->acpc(), $this->apcp(), $this->yrrp(), $this->saad(),
                    "rsbsa" . $prevYear, "agriagra" . $prevYear, "regular" . $prevYear, "punla" . $prevYear, "apcp" . $prevYear, "yrrp" . $prevYear, "saad" . $prevYear,
                );
            } else {
                $table = array(
                    $this->rsbsa(), $this->agriagra(), $this->regular(), $this->acpc(), $this->apcp(), $this->yrrp(), $this->saad(),
                );

            }

            return $table;
        } else {
            $this->eject();
        }
    }

    public function tableList_print()
    {
        if (isset($_SESSION['token'])) {
            $table = array(
                $this->rsbsa(), $this->agriagra(), $this->acpc(), $this->apcp(), $this->yrrp(), $this->saad(),
            );
            return $table;
        } else {
            $this->eject();
        }
    }

    public function eject()
    {

        echo "Session_expire";

    }

}