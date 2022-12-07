<?php
function charlimit($s)
{
    if (strlen($s) > 1  && strlen($s) < 45) {
        return true;
    }
    return false;
}

function checkdatefmt($d)
{
    $i = date_parse($d);

    if (!checkdate($i['month'], $i['day'], $i['year'])) {
        return false;
    }
    return "{$i['year']}-{$i['month']}-{$i['day']}";
}
