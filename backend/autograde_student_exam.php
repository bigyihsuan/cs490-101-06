<?php
include(__DIR__ . "/../account.php");
global $db;

// $exam_id = $_POST['exam_id'];
// $student_id = $_POST['student_id'];
// get the results from the database


$get_all_students_that_took_this_exam = <<<SQL
SELECT DISTINCT student
FROM 
SQL;

$get_all_results_of_exam = <<<SQL
SELECT student, exam_question, score, comment, max_score
FROM `Result`
JOIN `ExamQuestion` ON `ExamQuestion`.id=`Result`.exam_question
WHERE student=15
SQL;

$get_test_cases_of_question = <<<SQL

SQL;

$code = <<<PY
def add(a, b):
 return a+b
print(add(10, -5))
PY;
// $code = addslashes($code);

$output = shell_exec("python3 -c \"{$code}\"");
echo "PHP: " . $output;

// $result = $db->query($query);
// $rows = $result->fetch_all(MYSQLI_ASSOC);

// /* need per question:
// * results student response
// * question max score
// */

// foreach ($rows as $row) {
// }