<?php
include(__DIR__ . "/../account.php");
global $db;

$student = $_POST['student'];
$exam_title = $_POST['exam_title'];

$get_ids = <<<SQL
SELECT DISTINCT
    StudentExamResult.student,
    StudentExamResult.exam
FROM StudentExamResult
JOIN User ON User.id=StudentExamResult.student
JOIN Exam ON Exam.id=StudentExamResult.exam
WHERE User.username="{$student}" && Exam.title="{$exam_title}"
;
SQL;

($result = $db->query($get_ids)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);
$student_id = $rows[0]['student'];
$exam_id = $rows[0]['exam'];

$release_exam_results = <<<SQL
UPDATE StudentExamResult
SET released=1
WHERE student=$student_id && exam=$exam_id
;
SQL;

$db->query($release_exam_results);