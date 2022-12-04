<?php

class Database extends PDO {

    public function __construct($datasource = [])	{
        if (!$datasource) {
            $datasource = "mysql:dbname=mswdo;host=localhost;;mswdo;;74123";
        }

        [$dsn, $user, $pass] = explode(";;", $datasource);

        try { 
            parent::__construct($dsn, $user, $pass);
        }
        catch (PDOException $e) {
            exit($e->getMessage());
        }

        $driver = parent::getAttribute(PDO::ATTR_DRIVER_NAME);

        if ($driver == "mysql") {
            parent::exec("SET CHARACTER SET utf8");
            parent::exec("SET NAMES utf8 COLLATE utf8_general_ci");
            parent::exec("SET time_zone='+8:00'");
        }		
	}

    public function addMembers() {
        return 0;
    }

    public function getMembers() {
        $x = $this->exec("SELECT * FROM members");
        return $x;
    }
}


$d = new Database();

var_dump($d->addMembers());