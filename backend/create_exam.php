<?php
include("./account.php");
include("./data_models.php");
global $db;

// get post request from web page as json
// should be id-id
/*
{ // this is an array of question-score pairs
    question_score: [
        { qid: 5, score: 10 },
        { qid: 1, score: 5 },
        { qid: 6, score: 15 },
        // etc
    ]
}
*/
$questions = array();

foreach ($_POST['question_score'] as $qid => $score) {
    $questions[$qid] = $score;
}

// push an exam into the database

$insert_exam = "INSERT INTO `Exam` (`title`) VALUES (\"{$_POST['exam_title']}\");";
$db->query($insert_exam);
// get id of inserted exam
$exam_id = $db->insert_id;

// assign the exam id to the question in the query
// exam id, question id, max score
$insert_exam_questions = "INSERT INTO `ExamQuestion` (`exam`, `question`, `max_score`) VALUES ";
foreach ($questions as $question_id => $max_score) {
    $insert_exam_questions .= "({$exam_id}, {$question_id}, {$max_score}),";
}
$insert_exam_questions = substr($insert_exam_questions, 0, strlen($insert_exam_questions) - 1) . ";";

// push to the database
$db->query($insert_exam_questions);