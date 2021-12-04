<?php
include(__DIR__ . "/../account.php");
include(__DIR__ . "/data_models.php");
global $db;

// error_log(print_r("{$_POST['question']}, {$_POST['category']}, {$_POST['difficulty']}, {$_POST['useConstraint']}, {$_POST['constraint']}", true));

$question = new Question(
    $db->escape_string($_POST['question']),
    $db->escape_string($_POST['category']),
    $db->escape_string($_POST['difficulty']),
    isset($_POST['useConstraint']) ? $db->escape_string($_POST['constraint']) : ""
);

// error_log(print_r("{$_POST['question']}, {$_POST['category']}, {$_POST['difficulty']}, {$_POST['useConstraint']}, {$_POST['constraint']}", true));

$test_cases = array();

foreach ($_POST as $key => $value) {
    if (strpos($key, "test_cases")) {
        $case = json_decode($value);
        foreach ($case as $in => $out) {
            $test_case = new TestCase($db->escape_string($in), $db->escape_string($out));
            $test_cases[] = $test_case;
        }
    }
}

// foreach ($test_cases as $case) {
//     error_log(print_r("{$case->in} {$case->out}\n", true));
// }

($result1 = $db->query("SELECT * FROM `DifficultyTypes` ORDER BY id;")) or die();
$difficulties = $result1->fetch_all(MYSQLI_ASSOC);
$ind = array_search($question->difficulty, array_column($difficulties, 'difficulty'));
$question->difficulty_id = $difficulties[$ind]['id'];
// error_log(print_r($question->difficulty_id, true));

($result2 = $db->query("SELECT * FROM `CategoryTypes` ORDER BY id;")) or die();
$categories = $result2->fetch_all(MYSQLI_ASSOC);
$ind = array_search($question->category, array_column($categories, 'category'));
$question->category_id = $categories[$ind]['id'];
// error_log(print_r($question->category_id, true));

if (strcmp($question->constraint, "") !== 0) {
    ($result3 = $db->query("SELECT * FROM `ConsTypes` ORDER BY id;")) or die();
    $constraints = $result3->fetch_all(MYSQLI_ASSOC);
    $ind = array_search($question->constraint, array_column($constraints, 'cons'));
    $question->constraint_id = $constraints[$ind]['id'];
} else {
    $question->constraint_id = 0;
}
error_log(print_r($question->constraint_id, true));
// error_log(print_r("{$_POST['question']}, {$_POST['category']}, {$_POST['difficulty']}, {$_POST['useConstraint']}, {$_POST['constraint']}", true));

$question_insertion =
    "INSERT INTO `Question` (`prompt`, `difficulty`, `category`, `cons`)
    VALUES (\"{$question->prompt}\", {$question->difficulty_id}, {$question->category_id}, {$question->constraint_id});";
error_log(print_r("[AAAA] $question_insertion", true));
$db->query($question_insertion);

$question_id = $db->insert_id;
$testcase_ids = array();
foreach ($test_cases as $case) {
    $insert_testcases = <<<SQL
    INSERT INTO `TestCase` (`input`, `output`) VALUES 
    SQL;
    $insert_testcases .= "(\"{$case->in}\", \"{$case->out}\"),";
    $insert_testcases = substr($insert_testcases, 0, strlen($insert_testcases) - 1) . ";";
    $db->query($insert_testcases);
    $testcase_ids[] = $db->insert_id;
}

// if ($question->constraint_id != 0) {
//     // insert into the test case table a dummy test case for this constraint
//     $insert_constraint = <<<SQL
//     INSERT INTO `TestCase` (`input`, `output`) VALUES
//     ($question->constraint_id, $question->constraint_id);
//     SQL;

// }

$link_question_to_testcases = "INSERT INTO `QuestionTestCase` (`question`, `test_case`) VALUES ";
foreach ($testcase_ids as $testcase_id) {
    $link_question_to_testcases .= "($question_id, $testcase_id),";
}
$link_question_to_testcases = substr($link_question_to_testcases, 0, strlen($link_question_to_testcases) - 1) . ";";
$db->query($link_question_to_testcases);