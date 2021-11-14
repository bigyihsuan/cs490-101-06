<?php
include(__DIR__ . "/../account.php");
global $db;

// get exam titles for student selection
$get_exam_list = "SELECT `id` AS `id`, `title` AS `title` FROM `Exam`;";
($result = $db->query($get_exam_list)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);

$exam_table = <<<HTML
<table id="exam_table" style="width:50%;background:#ededed;padding-left:10px;padding-right:10px;padding-top:35px;" valign="top">
    <thead>
        <th id="exam_id" style="display:none;">ID</th>
        <th id="exam_title">Title</th>
        <th></th>
    </thead>
    <tbody>
HTML;

foreach ($rows as $row) {
    // error_log(print_r($row, true));
    $exam_table .= <<<HTML
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td><button type="button" onclick="goToExam({$row['id']})">Take Exam</button></td>
        </tr>
    HTML;
}

$exam_table .= <<<HTML
    </tbody>
</table>
HTML;

// error_log(print_r($exam_table, true));

echo $exam_table;