#!/usr/bin/php
<?php

require 'db.php';

$db = new Database();

//var_dump($db->addMgmt(['email'=>'hello@domain.tld','passwd'=>'hello123']));
var_dump( $db->addMember(["brgy" => "1","purok" => "aaa","fname" => "aaaa","mname" => "aaa","lname" => "aa","suffix" => "","gender" => "Female","dob" => "2023-02-07","pob" => "calape"]) );