<?php
header('content-type: application/json');

$req = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

if ($req !== 'POST') {
    http_response_code(403);
    exit;
}

$post = filter_input_array(INPUT_POST);

if (!$post) { 
    $raw = file_get_contents('php://input');

    if (strlen($raw) < 62) {
        http_response_code(403);
        exit;
    }

    $post = base64_decode($raw);
    $post = json_decode($post, true);
}

require 'db.php';
require 'fn.php';

if ($post['tbl'] == 'login') {

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

    if ($db->getMgmtBy($post)) {
        $uid = uniqid();
        setcookie('uid', $uid, time() + 120, '/');
        file_put_contents('/tmp/' . $uid, 'mgmt');
        exit;
    }
}

http_response_code(403);