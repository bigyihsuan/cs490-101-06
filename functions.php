<?php
// error catching
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);

// sql boilerplate
include("account.php");

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

function safe_post($name)
{
    global $db;

    $v = $_POST[$name];
    $v = trim($v);
    if ($v != "") {
        $v = mysqli_real_escape_string($db, $v);
    }
    return $v;
}

function is_authenticated($username, $password) {
    global $db;

    // get the matchings users
    // if none, don't bother checing password and go back to login
    $num_users_query = "SELECT * FROM users WHERE name='$username'";
    ($users = $db->query($num_users_query)) or die($db->error);

    if ($users->num_rows == 0) {
        return false;
    }

    // get the full row of $username
    $row = $users->fetch_assoc();
    $password_hash = $row['pass'];

    return password_verify($password, $password_hash);
}

