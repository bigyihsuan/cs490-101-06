<?php
include(__DIR__ . "/../account.php");
global $db;

$exam_title = $_POST['exam_title'];
$student = $_POST['student'];
// error_log($exam_id);

// get exam, and associated results
$get_results_of_student_on_exam = <<<SQL
SELECT
    StudentExamResult.id,
    StudentExamResult.student,
    StudentExamResult.exam,
    StudentExamResult.result,
    Result.response,
    Result.score,
    ExamQuestion.max_score,
    Result.comment
FROM StudentExamResult
JOIN User ON User.id=StudentExamResult.student
JOIN Exam ON Exam.id=StudentExamResult.exam
JOIN Result ON Result.id=StudentExamResult.result
JOIN ExamQuestion ON ExamQuestion.id=Result.exam_question
WHERE
    User.username="{$student}" && Exam.title="{$exam_title}"
;
SQL;
($result = $db->query($get_results_of_student_on_exam)) or die();
$student_results = $result->fetch_all(MYSQLI_ASSOC);

// error_log(print_r($rows, true));

$results = <<<HTML
<h1>$title</h1>
<p id="exam_id" style="display:none;">$exam_id</p>
<table id="exam_results" align="center" border="1px" style="width: 600px; line-height: 40px;">
<thead>
    <tr>Student Response</tr>
    <tr>Student Score</tr>
    <tr>Question Max Score</tr>
    <tr>Comment</tr>
</thead>
HTML;

foreach ($student_results as $student_result) {
    // keys: exam_title, result, max_score
    // error_log(print_r($row, true));
    $id = $student_result['id'];
    $response = $student_result['response'];
    $score = $student_result['score'];
    $max_score = $student_result['max_score'];
    $comment = $student_result['comment'];

    $result_row = <<<HTML
    <tr id="{$id}">
        <td>{$response}</td>
        <td><input id="score_{$id}" type="text"> {$score}</td>
        <td>{$max_score}</td>
        <td><input id="comment_{$id}" type="text"> {$comment}</td>
    </tr>
    HTML;
    $results .= $result_row;
}

$results .= <<<HTML
</table>
HTML;
// error_log($results);

echo $results;