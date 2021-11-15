<?php
include(__DIR__ . "/../account.php");
global $db;

// get result titles for student selection
$get_result_list = <<<SQL
SELECT DISTINCT
    User.username AS `student`,
    Exam.title AS `exam_title`
FROM StudentExamResult
JOIN User ON User.id=StudentExamResult.student
JOIN Exam ON Exam.id=StudentExamResult.exam
;
SQL;
($result = $db->query($get_result_list)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);

$result_table = <<<HTML
<table id="result_table" style="width:50%;background:#ededed;padding-left:10px;padding-right:10px;padding-top:35px;" valign="top">
    <thead>
        <!-- <th id="result_id" style="display:none;">ID</th> -->
        <th>Student</th>
        <th>Exam</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
HTML;

foreach ($rows as $row) {
    // error_log(print_r($row, true));
    $result_table .= <<<HTML
        <tr>
            <td>{$row['student']}</td>
            <td>{$row['exam_title']}</td>
            <td><button type="button" onclick=goToExamResult("{$row['student']}","{$row['exam_title']}")>View Result</button></td>
            <td><button type="button" onclick=releaseExamResult("{$row['student']}","{$row['exam_title']}")>Release Result</button></td>
        </tr>
    HTML;
}

$result_table .= <<<HTML
    </tbody>
</table>
HTML;

// error_log(print_r($result_table, true));

echo $result_table;