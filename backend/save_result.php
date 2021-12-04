<?php
include(__DIR__ . "/../account.php");
global $db;

$ser_id = $_POST['ser_id'];
$new_results = $_POST['new_results'];

foreach ($new_results as $new_result) {
    $result_id = $new_result['result_id'];
    $test_case_id = $new_result['test_case_id'];
    $comment = $new_result['comment'];
    $new_score = $new_result['new_score'];

    $update_result = <<<SQL
        UPDATE ResultTestCase
        SET score=$new_score, comment="$comment"
        WHERE result=$result_id && test_case=$test_case_id;
    SQL;

    error_log($update_result);

    $db->query($update_result);
}