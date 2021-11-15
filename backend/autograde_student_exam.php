<?php
include(__DIR__ . "/../account.php");
global $db;

$exam_id = $_POST['exam_id'];
$student_id = $_POST['student_id'];
// get the results from the database


$student_ids = "";

$get_all_results_of_exam = <<<SQL
SELECT student, exam_question, score, comment, max_score
FROM `Result`
JOIN `ExamQuestion` ON `ExamQuestion`.id=`Result`.exam_question
WHERE student=15
SQL;

$result = $db->query($query);
$rows = $result->fetch_all(MYSQLI_ASSOC);

/* need per question:
* results student response
* question max score
*/

foreach ($rows as $row) {
}