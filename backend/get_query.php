<?php
include("../util/functions.php");
global $db;

$username = "";
$password = "";
if (isset($_GET['username'])) {
    $username = safe_get('username');
}
if (isset($_GET['password'])) {
    $password = safe_get('password');
    // TODO: hash passwords
    // hash("sha256", $password)
}

$query = "SELECT * FROM cs490_Users WHERE name='$username' AND pass='$password'";
// $query = "SELECT * FROM cs490_Users";
($users = $db->query($query)) or die($db->error);

while ($row = $users->fetch_assoc()) {
    printf("<p>id={$row['user_id']} name={$row['name']} pass={$row['pass']} access={$row['access']}</p>");
}