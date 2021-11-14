<?php
include(__DIR__ . "/../account.php");
global $db;

session_start();

$insert_student_response = <<<SQL
INSERT INTO `Result` (`student`, `exam_question`, `response`)
VALUES 
SQL;


$student_id = $_SESSION['logged_user'];
// format per row:
// exam_question_id => question response
$responses = $_POST['student_responses'];
error_log(print_r($responses, true));

foreach ($responses as $question_response) {
    $exam_question_id = $question_response['exam_question_id'];
    $response_text = $question_response['student_response'];
    $insert_student_response .= <<<SQL
($student_id, $exam_question_id, "$response_text"),
SQL;
}
$insert_student_response = substr($insert_student_response, 0, strlen($insert_student_response) - 1) . ";";
// error_log($insert_student_response);
$db->query($insert_student_response);