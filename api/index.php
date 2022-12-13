<?php

$uid = filter_input(INPUT_COOKIE, 'uid');

if (!$uid) {
    http_response_code(401);
    exit;
}

if (!file_exists('/tmp/' . $uid)) {
    http_response_code(401);
    exit;
}

require 'db.php';
require 'fn.php';

header('content-type: application/json');

$req = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

if (!in_array($req, ['GET', 'POST', 'PATCH', 'DELETE'])) {
    http_response_code(401);
    exit;
}

$post = filter_input_array(INPUT_POST);

if ($post['tbl'] == 'mgmt') {

    $required_fields = ['email', 'passwd'];

    unset($post['tbl']);

    if (count($post) < count($required_fields)) {
        http_response_code(400);
        exit;
    }

    foreach ($post as $rf => $val) {
        if (!in_array($rf, $required_fields)) {
            http_response_code(400);
            exit;
        }

        if (!charlimit($val)) {
            echo $rf;
            http_response_code(406);
            exit;
        }

        if ($rf == 'email' && !filter_var($val, FILTER_VALIDATE_EMAIL)) {
            echo $rf;
            http_response_code(406);
            exit;
        }

        if ($rf == 'passwd') {
            $post[$rf] = hash("sha256", $val);
        }
    }

    $db = new Database();

    if ($db->addMgmt($post)) {
        http_response_code(201);
        exit;
    }
}

if ($post['tbl'] == 'members') {

    $required_fields = ['fname', 'lname', 'mname', 'dob', 'pob', 'purok', 'brgy'];

    unset($post['tbl']);

    if (count($post) < count($required_fields)) {
        http_response_code(400);
        exit;
    }

    foreach ($post as $rf => $val) {
        if (!in_array($rf, $required_fields)) {
            http_response_code(400);
            exit;
        }

        if ($rf == 'dob' && !checkdatefmt($val)) {
            echo $rf;
            http_response_code(406);
            exit;
        }

        if (!charlimit($val)) {
            echo $rf;
            http_response_code(406);
            exit;
        }
    }

    $db = new Database();

    if ($db->addMember($post)) {
        http_response_code(201);
        exit;
    }
}

if ($post['tbl'] == 'members_attr') {

    $required_fields = ['member_id', 'attrib_value', 'remarks'];

    unset($post['tbl']);

    if (count($post) < count($required_fields)) {
        http_response_code(400);
        exit;
    }

    foreach ($post as $rf => $val) {
        if (!in_array($rf, $required_fields)) {
            http_response_code(400);
            exit;
        }

        if (!charlimit($val)) {
            echo $rf;
            http_response_code(406);
            exit;
        }
    }

    $db = new Database();

    if ($db->membersAttrib($post)) {
        http_response_code(201);
        exit;
    }
}

if ($post['tbl'] == 'members_contact_info') {

    $required_fields = ['member_id', 'contact_id', 'relationship'];

    unset($post['tbl']);

    if (count($post) < count($required_fields)) {
        http_response_code(400);
        exit;
    }

    foreach ($post as $rf => $val) {
        if (!in_array($rf, $required_fields)) {
            http_response_code(400);
            exit;
        }

        if (!charlimit($val)) {
            echo $rf;
            http_response_code(406);
            exit;
        }
    }

    $db = new Database();

    if ($db->membersContact($post)) {
        http_response_code(201);
        exit;
    }
}

if ($post['tbl'] == 'households') {

    $required_fields = ['member_id', 'head_id', 'psa_ref'];

    unset($post['tbl']);

    if (count($post) < count($required_fields)) {
        http_response_code(400);
        exit;
    }

    foreach ($post as $rf => $val) {
        if (!in_array($rf, $required_fields)) {
            http_response_code(400);
            exit;
        }

        if (!charlimit($val)) {
            echo $rf;
            http_response_code(406);
            exit;
        }
    }

    $db = new Database();

    if ($db->addToHousehold($post)) {
        http_response_code(201);
        exit;
    }
}

if ($post['tbl'] == 'programs') {

    $required_fields = ['name', 'class', 'description'];

    unset($post['tbl']);

    if (count($post) < count($required_fields)) {
        http_response_code(400);
        exit;
    }

    foreach ($post as $rf => $val) {
        if (!in_array($rf, $required_fields)) {
            http_response_code(400);
            exit;
        }

        if (!charlimit($val)) {
            echo $rf;
            http_response_code(406);
            exit;
        }
    }

    $db = new Database();

    if ($db->addToHousehold($post)) {
        http_response_code(201);
        exit;
    }
}