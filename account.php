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

<!--
cmd: mysql -h us-cdbr-east-04.cleardb.com -u b9960caeae98e0 -p5ee5fe3e
database name: heroku_454624e55acb805
-->