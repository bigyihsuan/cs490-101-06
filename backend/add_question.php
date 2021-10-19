<?php
// include("../account.php");
// global $db;

session_start();

error_log(print_r($_POST, true));

// foreach (array_keys($_POST) as $key) {
//     error_log(print_r($key, true));
//     error_log(print_r($_POST[$key], true));
// }

foreach ($_POST as $key => $value) {
    error_log("$key => $value");
    if (strpos($key, "test_cases") !== false) {
        $case = json_decode($value);
        foreach ($case as $key => $value) {
            error_log("$key => $value");
        }
    }
}