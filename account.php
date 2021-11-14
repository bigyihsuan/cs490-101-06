<?php
// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
// ini_set('display_errors', 1);

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

// $hostname = $url["host"];
// $username = $url["user"];
// $password = substr($url["path"], 1);
// $project  = $url["pass"];

$hostname = "us-cdbr-east-04.cleardb.com";
$username = "b9960caeae98e0";
$password = "5ee5fe3e";
$project  = "heroku_454624e55acb805";

$db = new mysqli($hostname, $username, $password, $project);
if (mysqli_connect_errno()) {
    exit();
}


// cmd: mysql -h us-cdbr-east-04.cleardb.com -u b9960caeae98e0 -p5ee5fe3e
// database name: heroku_454624e55acb805

/* test users:
tom (teacher): hello
stu (student): goodbye
sam (student): goodbye
*/