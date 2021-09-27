<?php
include("../util/functions.php");

session_start();

global $db;

$username = "";
$password = "";
if (isset($_POST['username'])) {
    $username = safe_post('username');
}
if (isset($_POST['password'])) {
    $password = safe_post('password');
    // TODO: hash passwords
    // hash("sha256", $password)
}

if ($username != "" && $password != "") {
    $_SESSION['is_logged'] = is_authenticated($username, $password);
    
    if ($_SESSION['is_logged']) {
        // get access level
        
    } else {
        // return to login

    }
}
?>
