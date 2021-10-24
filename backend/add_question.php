<?php

include("../account.php");
include("./data_models.php");
global $db;

use Question;
use TestCase;

error_log(print_r("{$_POST['question']}, {$_POST['type']}, {$_POST['difficulty']}", true));

$question = new Question(
    $_POST['question'],
    $_POST['type'],
    $_POST['difficulty']
);

$test_cases = array();

foreach ($_POST as $key => $value) {
    if (strpos($key, "test_cases") !== false) {
        $case = json_decode($value);
        foreach ($case as $in => $out) {
            $test_case = new TestCase($in, $out);
            $test_cases[] = $test_case;
        }
    }
}

foreach ($test_cases as $case) {
    error_log(print_r("{$case->in} {$case->out}\n", true));
}

$question_insertion =
    "INSERT INTO `Question` (prompt, difficulty, category)
    VALUES (\"{$question->prompt}\", \"{$question->difficulty}\", \"{$question->type}\");";
$db->query($question_insertion);

$question_id = $db->insert_id;
$insert_testcases =
    "INSERT INTO `TestCase` (`question`, `input`, `output`) VALUES";
foreach ($test_cases as $case) {
    $insert_testcases .= "({$question_id}, \"{$case->in}\", \"{$case->out}\"),";
}
$insert_testcases = substr($insert_testcases, 0, strlen($insert_testcases) - 1) . ";";
$db->query($insert_testcases);