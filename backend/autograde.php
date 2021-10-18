<?php
include("../util/functions.php");

global $db;

$exam_id = $_POST['exam_id'];
// get the results from the database
$student_ids = "";

$result = $db->query($query);
$rows = $result->fetch_all(MYSQLI_ASSOC);

/* need per question:
* results student response
* question max score
*/

foreach ($rows as $row) {
}