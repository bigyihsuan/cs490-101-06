<?php
include(__DIR__ . "/../account.php");
global $db;

$exam_id = $_POST["exam_id"];

// get exam, and associated questions
$get_exam =
    "SELECT
        `Exam`.`title` AS `exam_title`,
        `Question`.`prompt` AS `question`,
        `ExamQuestion`.`max_score` AS `max_score` 
    FROM `Exam`
    JOIN `ExamQuestion` ON `Exam`.`id`=`ExamQuestion`.`exam`
    JOIN `Question` ON `ExamQuestion`.`question`=`Question`.`id`
    WHERE `Exam`.`id`={$exam_id}";
($result = $db->query($get_exam)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);

foreach ($rows as $row) {
    // keys: exam_title, question, max_score
    print_r($row);
}