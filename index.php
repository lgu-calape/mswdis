<?php
$origin = filter_input(INPUT_SERVER,'HTTP_ORIGIN');
header('Access-Control-Allow-Origin: ' . $origin);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: DELETE, GET, PATCH, POST');
header('Content-Type: application/json;charset=utf-8');

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

$req = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

if (!in_array($req, ['GET', 'POST', 'PATCH', 'DELETE'])) {
    http_response_code(401);
    exit;
}

$get = filter_input_array(INPUT_GET);
$post = filter_input_array(INPUT_POST);

if ($get['tbl'] == 'members') {
  $db = new Database();

  if ($get['id'] > 0) {
    $res = $db->getMembersBy(['id' => $get['id']]);

    echo json_encode($res);
    exit;
  }

  $res = $db->getMembers();

  echo json_encode($res);
  exit;
}

if ($get['tbl'] == 'attribs') {
    $db = new Database();

    if ($get['id'] > 0) {
        $res = $db->getAttribsBy(['member_id' => $get['id']]);

        echo json_encode($res);
        exit;
    }

    $res = $db->getAttribs(['member_id' => $get['id']]);

    echo json_encode($res);
    exit;
}

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

if ($post['tbl'] == 'member') {

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

if ($post['tbl'] == 'household') {

    $required_fields = ['ref', 'member_id', 'relation', 'psa_ref'];

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

if ($post['tbl'] == 'attrib') {

    $required_fields = ['aname', 'atype', 'avalue','member_id'];

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

    if ($db->addAttrib($post)) {
        http_response_code(201);
        exit;
    }
}

if ($post['tbl'] == 'program') {

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

http_response_code(403);