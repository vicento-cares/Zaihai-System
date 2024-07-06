<?php

function is_valid_applicator_no($applicator_no) {
    $pos = strpos($applicator_no, "/");

    if ($pos === false) {
        return false;
    } else {
        return true;
    }
}

function is_valid_terminal_name($terminal_name) {
    $pos = strpos($terminal_name, "**");

    if ($pos === false) {
        return false;
    } else {
        return true;
    }
}

function split_applicator_no($applicator_no) {
    $applicator_no_arr = explode("/", $applicator_no);
    return $applicator_no_arr[1];
}

function split_terminal_name($terminal_name) {
    $terminal_name_arr = explode("**", $terminal_name);
    return $terminal_name_arr[0];
}