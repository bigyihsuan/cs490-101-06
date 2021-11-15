<?php
include(__DIR__ . "/../account.php");
global $db;

session_start();

$student_id = $_SESSION['logged_user'];
error_log("creating result for $student_id");
$responses = $_POST['student_responses'];
$exam_id = $_POST['exam_id'];

error_log(print_r($responses, true));

foreach ($responses as $question_response) {
    error_log(print_r($question_response, true));

    $insert_student_response = <<<SQL
INSERT INTO `Result` (`exam_question`, `response`)
VALUES 
SQL;
    $exam_question_id = $question_response['exam_question_id'];
    $response_text = $question_response['student_response'];
    $insert_student_response .= <<<SQL
($exam_question_id, "$response_text")
SQL;
    $insert_student_response .= ";";

    error_log($insert_student_response);

    $db->query($insert_student_response);
    $result_id = $db->insert_id;

    $insert_student_exam_result = <<<SQL
INSERT INTO `StudentExamResult` (`student`, `exam`, `result`)
VALUES ($student_id, $exam_id, $result_id);
SQL;
    error_log($insert_student_exam_result);
    $db->query($insert_student_exam_result);
}

error_log("Finished creating results");