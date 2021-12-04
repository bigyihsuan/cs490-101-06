<?php
include(__DIR__ . "/../account.php");
global $db;

$get_exam_list = <<<SQL
SELECT DISTINCT
    StudentExamResult.exam AS exam_id,
    User.username AS student_name,
    User.id AS student_id,
    Exam.title AS exam_title
FROM StudentExamResult 
JOIN Exam ON Exam.id=StudentExamResult.exam
JOIN User ON User.id=StudentExamResult.student
JOIN Result ON Result.id=StudentExamResult.result
-- WHERE StudentExamResult.released=0
;
SQL;
($result = $db->query($get_exam_list)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);

$exam_table = <<<HTML
<table id="exam_table" style="width:50%;background:#ededed;padding-left:10px;padding-right:10px;padding-top:35px;" valign="top">
    <thead>
        <th id="student" style="display:none;">Student</th>
        <th id="exam_title">Exam</th>
        <th></th>
    </thead>
    <tbody>
HTML;

foreach ($rows as $row) {
    // error_log(print_r($row, true));
    $exam_table .= <<<HTML
        <tr id="exam_id_{$row['exam_id']}">
            <td style="display:none;">{$row['exam_id']}</td>
            <td style="display:none;">{$row['student_id']}</td>
            <td>{$row['student_name']}</td>
            <td>{$row['exam_title']}</td>
            <td><button type="button" onclick="autogradeExam({$row['exam_id']}, `{$row['exam_title']}`, `{$row['student_name']}`)">Autograde Exam</button></td>
        </tr>
    HTML;
}

$exam_table .= <<<HTML
    </tbody>
</table>
HTML;

// error_log(print_r($exam_table, true));

echo $exam_table;