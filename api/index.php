<?php
require 'db.php';
require 'fn.php';

header('content-type: application/json');

$ref = filter_input(INPUT_SERVER, 'HTTP_X_REF');
$req = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

$rel = ['households','members','members_attr','members_contact_info','programs'];

if (!in_array($req, ['GET','POST','PATCH','DELETE']) || !in_array($ref,$rel)) {
    http_response_code(401);
    exit;
}

if ($req == 'POST' && $ref == 'member') {
    $d = file_get_contents('php://input');
    $d = base64_decode($d);
    $d = json_decode($d, true);

    $required_fields = ['fname', 'lname', 'mname', 'dob', 'pob', 'purok', 'brgy'];

    if (count($d) !== count($required_fields)) {
        echo "required fields: " . implode(", ", $required_fields);
        http_response_code(400);
        exit;
    }

    foreach ($required_fields as $rf) {
        if (!filter_var($d[$rf]) && !charlimit($rf)) {
            echo "missing required field: $rf";
            http_response_code(400);
            exit;
        }

        if ($rf == 'dob' && !checkdatefmt($d[$rf])) {
            echo "invalid date format: $rf";
            http_response_code(400);
            exit;
        }
    }

    $db = new Database();

    if ($db->addMember(array_values($d))) {
        http_response_code(201);
        exit;
    }
}

if ($req == 'POST' && $ref == 'members_attr') {
    $d = file_get_contents('php://input');
    $d = base64_decode($d);
    $d = json_decode($d, true);

    $required_fields = ['member_id', 'attrib_value', 'remarks'];

    if (count($d) !== count($required_fields)) {
        echo "required fields: " . implode(", ", $required_fields);
        http_response_code(400);
        exit;
    }

    foreach ($required_fields as $rf) {
        if (!filter_var($d[$rf]) && !charlimit($rf)) {
            echo "missing required field: $rf";
            http_response_code(400);
            exit;
        }
    }

    $db = new Database();

    if ($db->membersAttrib(array_values($d))) {
        http_response_code(201);
        exit;
    }
}

if ($req == 'POST' && $ref == 'members_contact_info') {
    $d = file_get_contents('php://input');
    $d = base64_decode($d);
    $d = json_decode($d, true);

    $required_fields = ['member_id', 'contact_id', 'relationship'];

    if (count($d) !== count($required_fields)) {
        echo "required fields: " . implode(", ", $required_fields);
        http_response_code(400);
        exit;
    }

    foreach ($required_fields as $rf) {
        if (!filter_var($d[$rf]) && !charlimit($rf)) {
            echo "missing required field: $rf";
            http_response_code(400);
            exit;
        }
    }

    $db = new Database();

    if ($db->membersContact(array_values($d))) {
        http_response_code(201);
        exit;
    }
}

if ($req == 'POST' && $ref == 'households') {
    $d = file_get_contents('php://input');
    $d = base64_decode($d);
    $d = json_decode($d, true);

    $required_fields = ['member_id', 'head_id', 'psa_ref'];

    if (count($d) !== count($required_fields)) {
        echo "required fields: " . implode(", ", $required_fields);
        http_response_code(400);
        exit;
    }

    foreach ($required_fields as $rf) {
        if (!filter_var($d[$rf]) && !charlimit($rf)) {
            echo "missing required field: $rf";
            http_response_code(400);
            exit;
        }
    }

    $db = new Database();

    if ($db->addToHousehold(array_values($d))) {
        http_response_code(201);
        exit;
    }
}

if ($req == 'POST' && $ref == 'programs') {
    $d = file_get_contents('php://input');
    $d = base64_decode($d);
    $d = json_decode($d, true);

    $required_fields = ['name', 'class', 'description'];

    if (count($d) !== count($required_fields)) {
        echo "required fields: " . implode(", ", $required_fields);
        http_response_code(400);
        exit;
    }

    foreach ($required_fields as $rf) {
        if (!filter_var($d[$rf]) && !charlimit($rf)) {
            echo "missing required field: $rf";
            http_response_code(400);
            exit;
        }
    }

    $db = new Database();

    if ($db->addToHousehold(array_values($d))) {
        http_response_code(201);
        exit;
    }
}