<?php
require 'db.php';
require 'fn.php';

$cmd = filter_input(INPUT_SERVER, 'HTTP_X_CMD');
$req = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

if (!$req) exit;

if ($cmd == 'add_member') {
    $d = file_get_contents('php://input');
    $d = base64_decode($d);
    $d = json_decode($d, true);   

    $required_fields = ['fname','lname','mname','dob','pob','purok','brgy'];

    if (count($d) !== count($required_fields)) {
        echo "required fields: " . implode(", ", $required_fields);
        http_response_code(400);
        exit;
    }

    foreach($required_fields as $rf) {
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
    $res = $db->addMember(array_values($d));

    var_dump($res);
}

if ($cmd == 'add_contact') {
    $d = file_get_contents('php://input');
    $d = base64_decode($d);
    $d = json_decode($d, true);   

    $required_fields = ['contact_id','relationship'];

    if (count($d) !== count($required_fields)) {
        echo "required fields: " . implode(", ", $required_fields);
        http_response_code(400);
        exit;
    }

    foreach($required_fields as $rf) {
        if (!filter_var($d[$rf]) && !charlimit($rf)) {
            echo "missing required field: $rf";
            http_response_code(400);
            exit;
        }
    }

    $db = new Database();
    $res = $db->addContact(array_values($d));

    var_dump($res);
}

exit(http_response_code(401));