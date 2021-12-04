<?php
include '../account.php';
session_start();
//var_dump($_SESSION);

$id = intval($_SESSION['logged_user']);

$query = <<<SQL
SELECT DISTINCT
    exam.id AS examid,
    Exam.title AS title
FROM studentexamresult
LEFT JOIN exam ON exam.id=studentexamresult.exam
WHERE student="{$id}" && released=1;
SQL;
// print $query;
$result = $db->query($query);
$rows = $result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows);

$table = '<table style="background:white">';
$table .= '<tr><th>Exam</th></tr>';
foreach ($rows as $k => $v) {
    $exam_id = intval($v['examid']);
    $title = htmlspecialchars($v['title']);
    // $result = intval($v['result']);

    $table .= <<<HTML
    <tr>
        <td><a href="viewExamResults.php?ser=$exam_id&student=$id">{$title}</a></td>
    </tr>
    HTML;
}
$table .= '</table>';
//print $table;
?>

<!DOCTYPE html>
<html>

<head>
    <link href="student.css" rel="stylesheet">
    <title>Student View Results Page</title>
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
                <a class="active" href="../backend/logout.php">Log Out</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <h1
        style="text-align:left; justify-content: center; line-height: 100px; color: #ebebeb;">
        View Results</h1>
    <?php
    echo $table;
    ?>
</body>

</html>
<?php
/*
SELECT * FROM StudentExamResult WHERE student=[student id] && released=1;
*/