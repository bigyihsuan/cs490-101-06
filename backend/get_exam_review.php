<?php
include(__DIR__ . "/../account.php");
global $db;

error_log(print_r($_POST, true));

$exam_title = $_POST['exam_title'];
$student = $_POST['student'];
error_log("[get_exam_review] $student $exam_title");

$get_ser_id = <<<SQL
SELECT StudentExamResult.id FROM StudentExamResult
JOIN User ON User.id=StudentExamResult.student
JOIN Exam ON Exam.id=StudentExamResult.exam
WHERE User.username="{$student}" && Exam.title="{$exam_title}";
SQL;
error_log("[get_exam_review] $get_ser_id");

($result = $db->query($get_ser_id)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);
error_log(print_r($rows, true));
$ser_id = $rows[0]['id'];

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
<h1>$exam_title by $student</h1>
<p id="ser_id" style="display:none;">{$ser_id}</p>
<table id="exam_results" align="center" border="1px" style="width: 600px; line-height: 40px;background: #ebebeb;">
<thead>
    <td>Student Response</td>
    <td>Student Score</td>
    <td>Question Max Score</td>
    <td>Comment</td>
</thead>
HTML;

foreach ($student_results as $student_result) {
    // keys: exam_title, result, max_score
    // error_log(print_r($row, true));
    $ser_id = $student_result['id'];
    $response = $student_result['response'];
    $score = $student_result['score'];
    $max_score = $student_result['max_score'];
    $comment = $student_result['comment'];

    $result_row = <<<HTML
    <tr>
        <td id="result_{$student_result['result']}_id" style="display:none;">{$student_result['result']}</td>
        <td>{$response}</td>
        <td><input id="score_{$ser_id}" type="number" value="{$score}"></td>
        <td>{$max_score}</td>
        <td><textarea id="comment_{$ser_id}" type="text" cols="40" rows="10">{$comment}</textarea></td>
    </tr>
    HTML;
    $results .= $result_row;
}

$results .= <<<HTML
</table>
HTML;
// error_log($results);

echo $results;