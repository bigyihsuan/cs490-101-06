<?php

/*viewExamResults.php */
include '../account.php';
session_start();

$student_id = $_POST['logged_student'];
$ser_id = intval($_GET['ser']);

$query = <<<SQL
SELECT Question.prompt, Result.score, ExamQuestion.max_score, Result.comment
FROM studentexamresult AS SER
JOIN User ON User.id=SER.student
JOIN Result ON Result.id=SER.result
JOIN ExamQuestion ON ExamQuestion.exam=SER.exam
JOIN Question ON Question.id=ExamQuestion.question
WHERE SER.student=$student_id && SER.exam=$ser_id;
SQL;
//WHERE SER.exam="'.intval($_GET['ser']).'"';

$result = mysqli_query($db, $query);
if (!$result) {
    if (mysqli_error($db)) {
        print mysqli_error($db);
    }
}
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$table = '<table class="table dark"><tr><th>Prompt</th><th>Score</th><th>Max score</th><th>Comment</th>';
foreach ($rows as $k => $v) {
    $table .= '<tr><td>' . $v['prompt'] . '</td><td>' . $v['score'] . '</td><td>' . $v['max_score'] . '</td><td>' . $v['comment'] . '</td></tr>';
}

$table .= '</table>';

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
                <a href="./Student.php">Home</a>
            </li>
            <li>
                <a href="./ListExam.html">List Exams</a>
            </li>
            <li>
                <a href="./Review.html">Review Exam</a>
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

echo $table;

echo '</body>

</html>';