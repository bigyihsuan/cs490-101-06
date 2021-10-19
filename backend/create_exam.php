<?php
include("/account.php");
global $db;

class Exam
{
    public $exam_title;
    public $question_to_num = [];
    public $question_to_score = [];

    public function __construct($et)
    {
        $this->exam_title = $et;
    }
}

$exam = new Exam($_POST["exam_title"]);

foreach ($_POST as $key => $value) {
    if (strpos($key, "questions") !== false) {
        $questions = json_decode($value);
        // question = {question id: {number: int, points: int}}
        foreach ($questions as $question_id => $num_to_points) {
            $question_num = $num_to_points["number"];
            $point_value = $num_to_points["points"];
            $exam->question_to_num[$question_id] = $question_num;
            $exam->question_to_score[$question_id] = $point_value;
        }
    }
}

$transaction = "BEGIN TRANSACTION\nDECLARE @exam_id INT;\n";
$query = "INSERT INTO `Exam`
(exam_title)
VALUES ($exam->exam_title);
SELECT @exam_id = LAST_INSERT_ID();\n";
$exam_to_questions = "";
foreach (array_keys($exam->question_to_num) as $question_id) {
    $question_num = $exam->question_to_num[$question_id];
    $question_score = $exam->question_to_score[$question_id];
    $exam_to_questions .= "INSERT INTO `ExamToQuestions` (exam_id, question_id, question_number, question_max_value) VALUES (@exam_id, $question_id, $question_num, $question_score);\n";
}
$commit = "COMMIT;";

$insert_exam = $transaction . $query . $exam_to_questions . $commit;
error_log(print_r($insert_exam, true));

$db->begin_transaction();

try {
    $db->query($insert_exam);
    $db->commit();
} catch (mysqli_sql_exception $exception) {
    $db->rollback();
    throw $exception;
}