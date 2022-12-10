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

    /* * * * * * * * * * * * * * * * * * * * *
     * BEGIN FUNCTION - INSERTS 
     * * * * * * * * * * * * * * * * * * * * */

    public function addMember($params = [])
    {
        $p = $this->prepare("INSERT INTO members(fname,lname,mname,dob,pob,purok,barangay) VALUES(?,?,?,?,?,?,?)");
        $p->execute($params);

        return $this->lastInsertId();
    }

    public function membersContact($params = [])
    {
        $p = $this->prepare("INSERT INTO members_contact_info(member_id,contact_id,relationship) VALUES(?,?,?)");
        $p->execute($params);

        return $this->lastInsertId();
    }

    public function membersAttrib($params = [])
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

    public function addToHousehold($params = [])
    {
        $p = $this->prepare("INSERT INTO households(member_id,head_id,psa_ref) VALUES(?,?,?)");
        $p->execute($params);

        return $this->lastInsertId();
    }

    /* * * * * * * * * * * * * * * * * * * * *
     * BEGIN FUNCTION GETTERS FROM tables
     * * * * * * * * * * * * * * * * * * * * */

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

    /* * * * * * * * * * * * * * * * * * * * * *
     * BEGIN FUNCTION GETTERS BY SPECIFIC FIELD
     * * * * * * * * * * * * * * * * * * * * * */

    public function getHouseholdsBy($param = [])
    {
        $params = ['head_id', 'member_id', 'psa_ref'];

        if (count($param) > 1) {
            return;
        }

        $key = key($param);

        if (!in_array($key, $params)) {
            return;
        }

        $sql = "SELECT * FROM households WHERE $key=?";

        $prep = $this->prepare($sql);
        $prep->execute(array_values($param));

        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembersBy($param = [])
    {
        $params = ['id', 'fname', 'lname', 'barangay'];

        if (count($param) > 1) {
            return;
        }

        $key = key($param);

        if (!in_array($key, $params)) {
            return;
        }

        $sql = "SELECT * FROM members WHERE $key=?";

        $prep = $this->prepare($sql);
        $prep->execute(array_values($param));

        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembersAttrib($param = [])
    {
        $params = ['member_id'];

        if (count($param) > 1) {
            return;
        }

        $key = key($param);

        if (!in_array($key, $params)) {
            return;
        }

        $sql = "SELECT * FROM members_attr WHERE $key=?";

        $prep = $this->prepare($sql);
        $prep->execute(array_values($param));

        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembersContactInfoBy($param = [])
    {
        $params = ['member_id'];

        if (count($param) > 1) {
            return;
        }

        $key = key($param);

        if (!in_array($key, $params)) {
            return;
        }

        $sql = "SELECT * FROM members_contact_info WHERE $key=?";

        $prep = $this->prepare($sql);
        $prep->execute(array_values($param));

        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembersByAttribBy($param = [])
    {
        $params = ['attrib_value', 'remarks'];

        if (count($param) > 1) {
            return;
        }

        $key = key($param);

        if (!in_array($key, $params)) {
            return;
        }

        $sql = "SELECT * FROM members t1 JOIN members_attr t2 ON t1.id=t2.member_id WHERE t2.$key=?";

        $prep = $this->prepare($sql);
        $prep->execute(array_values($param));

        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }
}
