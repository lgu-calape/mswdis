#!/usr/bin/php
<?php

require 'db.php';

$db = new Database();

var_dump($db->addMgmt(['email'=>'hello@domain.tld','passwd'=>'hello123']));