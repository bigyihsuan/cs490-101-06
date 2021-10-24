<?php
include("../account.php");
include("./data_models.php");
global $db;

$query = "SELECT * FROM `Question`;";
($result = $db->query($query)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);
// return questions ot caller
echo json_encode($rows);