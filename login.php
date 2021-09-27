<?php
include("functions.php");

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
        $access_level_query = "SELECT access FROM users WHERE name='$username'";
        ($users = $db->query($access_level_query)) or die($db->error);
        $row = $users->fetch_assoc();
        $access_level = $row['access'];

        if ($access_level == "ADMIN") {
            header("refresh:0; url=webpages/admin.html");
        } else {
            header("refresh:0; url=webpages/user.html");
        }
    } else {
        // return to login
        print "Incorrect username or password. Please try again.<br>";
        print "Redirecting in 5 seconds...";
        header("refresh:5; url=webpages/user.html");
    }
}
?>