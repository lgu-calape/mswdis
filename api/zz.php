<?php

$d = filter_input_array(INPUT_POST);

if (!$d) {
    echo 'error 400' . PHP_EOL;
    http_response_code(400);
    exit;
}

var_dump(filter_var($d['members']));

if (!filter_var($d['members'])) {
  echo 'error 401' . PHP_EOL;
  exit;
}

var_dump($d);