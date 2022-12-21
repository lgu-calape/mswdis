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

    public function addMgmt($params = [])
    {
        $p = $this->prepare("INSERT INTO mgmt(email,passwd) VALUES(:email,:passwd)");
        return $p->execute($params);
    }

    public function addMember($params = [])
    {
        $p = $this->prepare("INSERT INTO members(fname,lname,mname,dob,pob,purok,barangay) VALUES(:fname,:lname,:mname,:dob,:pob,:purok,:barangay)");
        return $p->execute($params);
    }

    public function addAttrib($params = []) {
        $p = $this->prepare("INSERT INTO attributions(aname,atype,avalue,member_id) VALUES(:aname,:atype,:avalue,:member_id)");
        return $p->execute($params);
    }

    public function addHousehold($params = [])
    {
        $p = $this->prepare("INSERT INTO households(ref,member_id,relation,psa_ref) VALUES(:ref,:member_id,:relation,:psa_ref)");
        return $p->execute($params);
    }

    public function addProgram($params = [])
    {
        $p = $this->prepare("INSERT INTO rel_members_programs(member_id,program_id) VALUES(:member_id,:program_id)");
        return $p->execute($params);
    }

    /* * * * * * * * * * * * * * * * * * * * *
     * BEGIN FUNCTION GETTERS FROM tables
     * * * * * * * * * * * * * * * * * * * * */

    public function getHouseholds()
    {
        return $this->query("SELECT DISTINCT(ref) FROM households")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembers()
    {
        return $this->query("SELECT * FROM members")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAttribs()
    {
        return $this->query("SELECT * FROM attibutions")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPrograms()
    {
        return $this->query("SELECT * FROM programs")->fetchAll(PDO::FETCH_ASSOC);
    }

    /* * * * * * * * * * * * * * * * * * * * * *
     * BEGIN FUNCTION GETTERS BY SPECIFIC FIELD
     * * * * * * * * * * * * * * * * * * * * * */

    public function getHouseholdsBy($param = [])
    {
        $params = ['ref','member_id', 'psa_ref'];

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

    public function getMgmtBy($params = [])
    {
        $prep = $this->prepare("SELECT * FROM mgmt WHERE email=:email AND passwd=:passwd");
        $prep->execute($params);

        return $prep->fetch(2);
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

        return $prep->fetch(PDO::FETCH_ASSOC);
    }

    public function getAttribsBy($param = [])
    {
        $params = ['member_id', 'aname', 'atype', 'avalue'];

        if (count($param) > 1) {
            return;
        }

        $key = key($param);

        if (!in_array($key, $params)) {
            return;
        }

        $sql = "SELECT * FROM attributions WHERE $key=?";

        $prep = $this->prepare($sql);
        $prep->execute(array_values($param));

        return $prep->fetch(PDO::FETCH_ASSOC);
    }
}
