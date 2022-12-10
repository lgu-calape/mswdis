#!/usr/bin/php
<?php
require 'db.php';

$db = new Database();

var_dump($db->getMembersByAttribBy(['attrib_value'=>'solo parent']));