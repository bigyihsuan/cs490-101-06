<?php
include("/account.php");
global $db;

class Question
{
    public $question_text;
    public $function_name;
    public $type;
    public $difficulty;
    public $test_cases = [];

    public function __construct($qt, $fn, $type, $diff)
    {
        $this->question_text = $qt;
        $this->function_name = $fn;
        $this->type = $type;
        $this->difficulty = $diff;
    }
}

class TestCase
{
    public $input;
    public $output;

    public function __construct($in, $out)
    {
        $this->input = $in;
        $this->output = $out;
    }
}

session_start();

error_log(print_r($_POST, true));

// foreach (array_keys($_POST) as $key) {
//     error_log(print_r($key, true));
//     error_log(print_r($_POST[$key], true));
// }

$question = new Question($_POST['question'], $_POST['function_name'], $_POST['type'], $_POST['difficulty']);

foreach ($_POST as $key => $value) {
    if (strpos($key, "test_cases") !== false) {
        $case = json_decode($value);
        foreach ($case as $in => $out) {
            $test_case = new TestCase($in, $out);
            $question->test_cases[count($question->test_cases)] = $test_case;
            // error_log(print_r("$in => $out", true));
        }
    }
}

error_log(print_r($question, true));

$transaction = "BEGIN TRANSACTION\nDECLARE @question_id INT; DECLARE @test_case_id INT;\n";
$query = "INSERT INTO `Question`
(question_text, function_name, difficulty, category)
VALUES ($question->question_text, $question->function_name, $question->difficulty, $question->type);
SELECT @question_id = LAST_INSERT_ID();\n";
// multiple test cases per quesiton; individually insert and capture
$test_case_insertion = "";
foreach ($question->test_cases as $key => $test_case) {
    $test_case_insertion .= "INSERT INTO `TestCase` (test_input, test_output) VALUES ($test_case->input, $test_case->output);\n";
    $test_case_insertion .= "SELECT @test_case_id = LAST_INSERT_ID();\n";
    $test_case_insertion .= "INSERT INTO `QuestionToTestCase` (question_id, test_case_id) VALUES (@question_id, @test_case_id);\n";
}
$commit = "COMMIT;";

$insert_question = $transaction . $query . $test_case_insertion . $commit;
error_log(print_r($insert_question, true));

$db->begin_transaction();

try {
    $db->query($insert_question);
    $db->commit();
} catch (mysqli_sql_exception $exception) {
    $db->rollback();
    throw $exception;
}