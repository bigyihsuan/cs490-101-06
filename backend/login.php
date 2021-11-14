<?php
include(__DIR__ . "/functions.php");

session_start();

global $db;

$username = "";
$password = "";
if (isset($_POST['username'])) {
    error_log($_POST['username']);
    $username = safe_post('username');
}
if (isset($_POST['password'])) {
    error_log($_POST['password']);
    $password = safe_post('password');
}

error_log("$username $password");

if ($username != "" && $password != "") {
    $_SESSION['is_logged'] = is_authenticated($username, $password);

    if ($_SESSION['is_logged']) {
        // get access level
        $access_level_query = "SELECT `id`, `access` FROM `User` WHERE `username`='$username'";
        ($users = $db->query($access_level_query)) or die($db->error);
        $row = $users->fetch_assoc();
        $_SESSION['logged_user'] = $row['id'];
        $_SESSION['access_level'] = $row['access'];
        echo $_SESSION['access_level'];
    } else {
        // return to login
        echo "<h2>Incorrect username or password. Please try again.</h2>";
    }
}