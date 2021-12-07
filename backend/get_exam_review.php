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
    ExamQuestion.max_score AS question_max_score,
    ResultTestCase.score,
    ResultTestCase.max_score AS part_max_score,
    ResultTestCase.comment,
    ResultTestCase.result,
    ResultTestCase.test_case
FROM StudentExamResult
JOIN User ON User.id=StudentExamResult.student
JOIN Exam ON Exam.id=StudentExamResult.exam
JOIN Result ON Result.id=StudentExamResult.result
JOIN ExamQuestion ON ExamQuestion.id=Result.exam_question
JOIN ResultTestCase ON ResultTestCase.result=Result.id
WHERE
    User.username="{$student}" && Exam.title="{$exam_title}"
;
SQL;

error_log($get_results_of_student_on_exam);

($result = $db->query($get_results_of_student_on_exam)) or die();
$student_results = $result->fetch_all(MYSQLI_ASSOC);

error_log(print_r($student_results, true));

$results = <<<HTML
<h1>$exam_title by $student</h1>
<!-- <p id="ser_id" style="display:none;">{$ser_id}</p> -->
<table id="exam_results" align="center" border="1px" style="width: 600px; line-height: 40px;background: #ebebeb;">
<thead>
    <td>Student Response</td>
    <td>Student Score</td>
    <td>Part Max Score</td>
    <td>Question Max Score</td>
    <td>Comment</td>
</thead>
HTML;

foreach ($student_results as $student_result) {
    // keys: exam_title, result, max_score
    // error_log(print_r($row, true));
    $ser_id = $student_result['id'];
    $result = $student_result['result'];
    $test_case = $student_result['test_case'];

    $response = $student_result['response'];
    $score = $student_result['score'];
    $question_max_score = $student_result['question_max_score'];
    $part_max_score = $student_result['part_max_score'];
    $comment = $student_result['comment'];

    $result_row = <<<HTML
    <tr>
        <td id="result_{$result}_id" style="display:none;">{$result}</td>
        <td id="test_case_{$test_case}_id" style="display:none;">{$test_case}</td>
        <td>{$response}</td>
        <td><input id="score_{$result}_{$test_case}" type="number" value="{$score}"></td>
        <td>{$part_max_score}</td>
        <td>{$question_max_score}</td>
        <td><textarea id="comment_{$result}_{$test_case}" type="text" cols="40" rows="10">{$comment}</textarea></td>
    </tr>
    HTML;
    $results .= $result_row;
}
// error_log($results);

$get_scores = <<<SQL
SELECT
    SUM(ResultTestCase.score) AS student_score,
    SUM(ResultTestCase.max_score) AS exam_score
FROM StudentExamResult
JOIN User ON User.id=StudentExamResult.student
JOIN Exam ON Exam.id=StudentExamResult.exam
JOIN Result ON Result.id=StudentExamResult.result
JOIN ExamQuestion ON ExamQuestion.id=Result.exam_question
JOIN ResultTestCase ON ResultTestCase.result=Result.id
WHERE
    User.username="{$student}" && Exam.title="{$exam_title}"
;
SQL;
($result = $db->query($get_scores)) or die();
$scores = $result->fetch_all(MYSQLI_ASSOC)[0];

error_log(print_r($scores, true));

$results .= <<<HTML
<td><b>Total Score:</b></td>
<td>{$scores['student_score']}</td>
<td>/</td>
<td>{$scores['exam_score']}</td>
HTML;

$results .= <<<HTML
</table>
HTML;

echo $results;