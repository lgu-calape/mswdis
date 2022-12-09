<?php

class Database extends PDO
{
    public function __construct($datasource = [])
    {
        if (!$datasource) {
            $datasource = "mysql:dbname=mswdo;host=localhost;;mswdo;;74123";
        }

        [$dsn, $user, $pass] = explode(";;", $datasource);

        try {
            parent::__construct($dsn, $user, $pass);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        $driver = parent::getAttribute(PDO::ATTR_DRIVER_NAME);

        if ($driver == "mysql") {
            parent::exec("SET CHARACTER SET utf8");
            parent::exec("SET NAMES utf8 COLLATE utf8_general_ci");
            parent::exec("SET time_zone='+8:00'");
        }
    }

    public function addMember($params = [])
    {
        $p = $this->prepare("INSERT INTO members(fname,lname,mname,dob,pob,purok,barangay) VALUES(?,?,?,?,?,?,?)");
        $p->execute($params);

        return $this->lastInsertId();
    }

    public function addContact($params = [])
    {
        $p = $this->prepare("INSERT INTO members_contact_info(member_id,contact_id,relationship) VALUES(?,?,?)");
        $p->execute($params);

        return $this->lastInsertId();
    }

    public function attrib($params = [])
    {
        $p = $this->prepare("INSERT INTO members_attr(member_id,attrib_value,remarks) VALUES(?,?,?)");
        $p->execute($params);

        return $this->lastInsertId();
    }

    public function programs($params = [])
    {
        $p = $this->prepare("INSERT INTO rel_members_programs(member_id,program_id) VALUES(?,?)");
        $p->execute($params);

        return $this->lastInsertId();
    }

    public function addHousehold($params = [])
    {
        $p = $this->prepare("INSERT INTO households(member_id,head_id,psa_ref) VALUES(?,?,?)");
        $p->execute($params);

        return $this->lastInsertId();
    }

    /* BEGIN FUNCTION GETTERS FROM tables */

    public function getHouseholds()
    {
        return $this->query("SELECT * FROM households")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembers()
    {
        return $this->query("SELECT * FROM members")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembersAttr()
    {
        return $this->query("SELECT * FROM members_attr")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembersContactInfo()
    {
        return $this->query("SELECT * FROM members_contact_info")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPrograms()
    {
        return $this->query("SELECT * FROM programs")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRelMembersPrograms()
    {
        return $this->query("SELECT * FROM rel_members_programs")->fetchAll(PDO::FETCH_ASSOC);
    }

    /* BEGIN FUNCTION GETTERS BY ID */

    public function getHouseholdsBy($params = [])
    {
        $_params = ['head_id','member_id','psa_ref'];

        if (count($params) > 1) {
            return;
        }

        $sql = "SELECT * FROM households WHERE ";

        foreach($params as $_param=>$_arg) {
            if (!in_array($_param,$_params)) {
                return;
            }
                        
            $arg = intval($_arg);

            if ($_param == 'psa_ref') {
                $arg = substr(trim($_arg), 0,12);
            }

            $sql .= $_param ."=" . $arg; break;
        }
        
        return $sql;

        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembersBy($params = [])
    {
        $_params = ['head_id','member_id','psa_ref'];

        if (!array_intersect($_params,array_keys($params))) {
            return;
        }

        $sql = "SELECT * FROM households WHERE ";

        foreach($params as $_param=>$_arg) {
            if (!in_array($_param,$_params)) {
                continue;
            }
                        
            $arg = intval($_arg);

            if ($_param == 'psa_ref') {
                $arg = substr(trim($_arg), 0,12);
            }

            $sql .= $_param ."=" . $arg; break;
        }

        return $sql;

        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}