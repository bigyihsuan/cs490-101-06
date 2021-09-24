<?php
// error catching
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);

// sql boilerplate
include("../account.php");
$db = mysqli_connect($hostname, $username, $password, $project);
if (mysqli_connect_errno()) {
    exit();
}

function safe_get($name)
{
    global $db;

    $v = $_GET[$name];
    $v = trim($v);
    if ($v != "") {
        $v = mysqli_real_escape_string($db, $v);
    }
    return $v;
}