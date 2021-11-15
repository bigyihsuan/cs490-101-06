<?php
include(__DIR__ . "/../account.php");
global $db;

$exam_id = $_POST["exam_id"];
// error_log($exam_id);

// get exam, and associated questions
$get_exam_title =
    "SELECT `Exam`.title AS `exam_title`
    FROM `Exam`
    WHERE `Exam`.`id`={$exam_id};";
($result = $db->query($get_exam_title)) or die();
$title = $result->fetch_assoc()['exam_title'];

$get_exam_form =
    "SELECT
        `ExamQuestion`.`id` AS `exam_question_id`,
        `Question`.`prompt` AS `question_prompt`
    FROM `Question`
    JOIN `ExamQuestion` ON `ExamQuestion`.`question`=`Question`.`id`
    JOIN `Exam` ON `Exam`.`id`=`ExamQuestion`.`exam`
    WHERE `Exam`.`id`={$exam_id};";
($result = $db->query($get_exam_form)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);

// error_log(print_r($rows, true));

$questions = <<<HTML
<h1>$title</h1>
<p id="exam_id" style="display:none;">$exam_id</p>
<table id="exam_questions" align="center" border="1px" style="width: 600px; line-height: 40px;">
HTML;

foreach ($rows as $row) {
    // keys: exam_title, question, max_score
    // error_log(print_r($row, true));
    $exam_question_id = $row['exam_question_id'];
    $question_prompt = $row['question_prompt'];
    $question_row = <<<HTML
    <tr>
        <td id="exam_question_{$exam_question_id}_id"style="display:none;">$exam_question_id</td>
        <td>$question_prompt</td>
    </tr>
    <tr>
        <td><textarea id="exam_question_id{$question_id}_answer" name="exam_question_{$exam_question_id}_answer" cols="40" rows="10"></textarea></td>
    </tr>
    HTML;
    $questions .= $question_row;
}

$questions .= <<<HTML
</table>
HTML;
// error_log($questions);

echo $questions;