<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$hostname = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$project = substr($url["path"], 1);

$db = new mysqli($hostname, $username, $password, $project);
if (mysqli_connect_errno()) {
    exit();
}
?>