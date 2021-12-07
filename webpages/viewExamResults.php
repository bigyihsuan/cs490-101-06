<?php

/*viewExamResults.php */
include '../account.php';
session_start();

$logged_user = $_SESSION['logged_user'];
// $ser = intval($_GET['ser']);

// $get_ser_id = <<<SQL
// SELECT StudentExamResult.id FROM StudentExamResult
// JOIN User ON User.id=StudentExamResult.student
// JOIN Exam ON Exam.id=StudentExamResult.exam
// WHERE User.username="{$student}" && Exam.title="{$exam_title}";
// SQL;
// error_log("[get_exam_review] $get_ser_id");

// ($result = $db->query($get_ser_id)) or die();
// $rows = $result->fetch_all(MYSQLI_ASSOC);
// error_log(print_r($rows, true));
$ser_id = intval($_GET['ser']);
$student_id = intval($_GET['student']);

($r = $db->query("SELECT `username` FROM User WHERE id=$student_id;")) or die();
$student_name = $r->fetch_all(MYSQLI_ASSOC)[0]['username'];

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
    ResultTestCase.test_case,
    Exam.title AS exam_title,
    User.username AS student_name
FROM StudentExamResult
JOIN User ON User.id=StudentExamResult.student
JOIN Exam ON Exam.id=StudentExamResult.exam
JOIN Result ON Result.id=StudentExamResult.result
JOIN ExamQuestion ON ExamQuestion.id=Result.exam_question
JOIN ResultTestCase ON ResultTestCase.result=Result.id
WHERE
    StudentExamResult.exam=$ser_id && StudentExamResult.student=$student_id
;
SQL;

error_log($get_results_of_student_on_exam);

($result = $db->query($get_results_of_student_on_exam)) or die();
$student_results = $result->fetch_all(MYSQLI_ASSOC);

error_log(print_r($student_results, true));

$exam_title = $student_results[0]['exam_title'];
$student = $student_results[0]['student_name'];

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
    $max_score = $student_result['part_max_score'];
    $question_max_score = $student_result['question_max_score'];
    $comment = $student_result['comment'];

    $result_row = <<<HTML
    <tr>
        <td id="result_{$result}_id" style="display:none;">{$result}</td>
        <td id="test_case_{$test_case}_id" style="display:none;">{$test_case}</td>
        <td>{$response}</td>
        <td>{$score}</td>
        <td>{$max_score}</td>
        <td>{$question_max_score}</td>
        <td>{$comment}</td>
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

echo '<!DOCTYPE html>
<html>

<head>
    <link href="student.css" rel="stylesheet">
    <title>View Exam Results Page</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="util.js"></script>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="Student.php">Home</a>
            </li>
            <li>
                <a href="ListExam.html">List Exams</a>
            </li>
            <li>
                <a href="viewResults.php">Review Exam</a>
            </li>
            <li>
                <a class="active" href="/backend/logout.php">Log Out</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <h1
        style="text-align:left; justify-content: center; line-height: 100px; color: #ebebeb;">
        View Exam results</h1>';

echo $results;

echo '</body>

</html>';