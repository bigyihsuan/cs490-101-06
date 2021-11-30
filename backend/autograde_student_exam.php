<?php
include(__DIR__ . "/../account.php");
global $db;

$exam_id = $_POST['exam_id'];
$exam_title = $_POST['exam_title'];
$student_name = $_POST['student_name'];

error_log("[autograde_student_exam] $exam_title | $student_name");

// $exam_id = 35;
// $student_id = 15;

$get_all_students_that_took_this_exam = <<<SQL
SELECT DISTINCT student
FROM StudentExamResult
JOIN User ON User.id=StudentExamResult.student
WHERE exam=$exam_id && User.username="{$student_name}";
SQL;

($result = $db->query($get_all_students_that_took_this_exam)) or die();
$student_ids = $result->fetch_all(MYSQLI_ASSOC);
foreach ($student_ids as $row) {
    $student_id = $row['student'];
    $get_all_results_of_exam_for_student = <<<SQL
    SELECT
        StudentExamResult.student AS student,
        StudentExamResult.exam AS exam,
        StudentExamResult.result AS result,
        question, comment, response, solution, ExamQuestion.max_score AS max_score
    FROM `Result`
    JOIN StudentExamResult ON Result.id=StudentExamResult.result
    JOIN ExamQuestion ON ExamQuestion.id=Result.exam_question
    JOIN Question ON Question.id=ExamQuestion.question
    JOIN User ON User.id=StudentExamResult.student
    WHERE StudentExamResult.student=$student_id;
    SQL;
    ($result = $db->query($get_all_results_of_exam_for_student)) or die();
    $student_results = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($student_results as $exam_result) {
        $result_id = $exam_result['result'];
        $solution = $exam_result['solution'];
        $question_id = $exam_result['question'];
        $get_test_cases_of_question = <<<SQL
            SELECT `input`, `output`, ConsTypes.cons AS constraint_name, ConsTypes.search_string AS search_string
            FROM TestCase
            JOIN QuestionTestCase ON QuestionTestCase.test_case=TestCase.id
            JOIN Question ON QuestionTestCase.question=Question.id
            JOIN ConsTypes ON ConsTypes.id=Question.cons
            WHERE QuestionTestCase.question=$question_id;
        SQL;
        ($result = $db->query($get_test_cases_of_question)) or die();
        $test_cases = $result->fetch_all(MYSQLI_ASSOC);

        $constraint = $test_cases[0]['constraint_name'];
        $hasConstraint = $constraint !== "None";
        $test_case_count = count($test_cases) + 1 + $hasConstraint ? 1 : 0;
        $max_score = $exam_result['max_score'];
        $score_per_case = $max_score / $test_case_count;
        $current_score = 0;
        $comment = "";

        $input_code = "";
        $expected_output = "";
        $constraint = "";
        $constraint_name = "";
        $cases = array();

        $fun_name = preg_split('/ /', preg_split('/\(/', $test_cases[0]['input'])[0])[1];
        // error_log(print_r($fun_name, true));
        // $fun_name = preg_split('/\(/', $test_cases[0]['input'])[0];
        // error_log(strpos($exam_result['response'], "("));

        // check function name
        $student_fun_name = preg_split('/ /', preg_split('/\(/', $exam_result['response'])[0])[1];
        error_log(print_r($student_fun_name, true));
        if ($student_fun_name !== $fun_name) {
            $exam_result['response'] = preg_filter("/$student_fun_name/", "/$fun_name/", $exam_result['response']);
            $comment .= "Incorrect function name: 0\n";
        } else {
            $comment .= "Correct function name: +$score_per_case\n";
            $current_score += $score_per_case;
        }

        foreach ($test_cases as $test_case) {
            // echo "$student_id $question_id " . print_r($test_case, true) . "\n";
            $input_code .= "print({$test_case['input']})\n";
            // echo "{$test_case['input']}\n";
            $cases[] = $test_case['input'];
            $expected_output .= $test_case['output'] . "\n";
            $constraint = $test_case['search_string'];
            $constraint_name = $test_case['constraint_name'];
        }

        $input_code = $exam_result['response'] . "\n" . $input_code;
        // echo $input_code . "\n";
        $actual_output = shell_exec("python3 -c \"{$input_code}\"");
        $expected_output = trim($expected_output);
        $actual_output = trim($actual_output);

        $expected_output = array_map(function ($e) {
            return (string)$e;
        }, preg_split("/\n/", $expected_output));
        $actual_output = array_map(function ($e) {
            return (string)$e;
        }, preg_split("/\n/", $actual_output));

        // print_r($expected_output);
        // print_r($actual_output);

        $output_map = array_map(null, $actual_output, $expected_output);
        $output_map = array_map(null, $cases, $output_map);
        // print_r($output_map);

        foreach ($output_map as $case) {
            // echo "$case {$pair[0]} {$pair[1]}\n";
            $pair = $case[1];
            if ($pair[0] == $pair[1]) {
                $comment .= "Succeeds $case[0]: +$score_per_case\n";
                $current_score += $score_per_case;
            } else {
                $comment .= "Fails $case[0]: 0\n";
            }
        }
        switch ($constraint) {
            case "for": {
                    if (!preg_match("/for .+:/", $solution)) {
                        $comment .= "Succeeds constraint $constraint_name: +$score_per_case\n";
                        $current_score += $max_score / $test_case_count;
                    } else {
                        $comment .= "Fails constraint $constraint_name: 0\n";
                    }
                    break;
                }
            case "while": {
                    if (!preg_match("/while .+:/", $solution)) {
                        $comment .= "Succeeds constraint $constraint_name: +$score_per_case\n";
                        $current_score += $max_score / $test_case_count;
                    } else {
                        $comment .= "Fails constraint $constraint_name: 0\n";
                    }
                    break;
                }
            case "def": {
                    if (!preg_match("/def (.+):.*($1)/", $solution)) {
                        $comment .= "Succeeds constraint $constraint_name: +$score_per_case\n";
                        $current_score += $max_score / $test_case_count;
                    } else {
                        $comment .= "Fails constraint $constraint_name: 0\n";
                    }
                    break;
                }
            default:
                break;
        }
        // echo "$current_score\n";
        // echo "$comment\n";
        // echo "$result_id";
        $update_result = <<<SQL
        UPDATE `Result`
        SET score=$current_score, comment="$comment"
        WHERE id=$result_id;
        SQL;
        $result = $db->query($update_result);
        // echo "$result\n";
    }
}