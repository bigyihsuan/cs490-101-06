<?php
// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
// ini_set('display_errors', 1);

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$hostname = $url["host"];
$username = $url["user"];
$password = substr($url["path"], 1);
$project  = $url["pass"];

$db = new mysqli($hostname, $username, $password, $project);
if (mysqli_connect_errno()) {
    exit();
}

/* test users:
tom (teacher): hello
stu (student): goodbye
sam (student): goodbye
*/