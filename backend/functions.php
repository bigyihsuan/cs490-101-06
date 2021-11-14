<?php
// sql boilerplate
include(__DIR__ . "/../account.php");

function safe_get($name)
{
    global $db;

    $v = $_GET[$name];
    $v = trim($v);
    if ($v != "") {
        $v = $db->real_escape_string($v);
    }
    return $v;
}

function safe_post($name)
{
    global $db;

    $v = $_POST[$name];
    $v = trim($v);
    if ($v != "") {
        $v = $db->real_escape_string($v);
    }
    return $v;
}

function is_authenticated($username, $password)
{
    global $db;

    // get the matchings users
    // if none, don't bother checing password and go back to login
    $num_users_query = "SELECT * FROM `User` WHERE `username`=\"$username\"";
    ($users = $db->query($num_users_query)) or die($db->error);

    if ($users->num_rows == 0) {
        return false;
    }

    // get the full row of $username
    $row = $users->fetch_assoc();
    $password_hash = $row['pass'];
    error_log(password_verify($password, $password_hash));
    return password_verify($password, $password_hash);
}