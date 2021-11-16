<?php
include(__DIR__ . "/../account.php");
global $db;

$ser_id = $_POST['ser_id'];
$new_results = $_POST['new_results'];

foreach ($new_results as $new_result) {
    $result_id = $new_result['result_id'];
    $comment = $new_result['comment'];
    $new_score = $new_result['new_score'];

    $update_result = <<<SQL
        UPDATE Result
        SET score=$new_score, comment="$comment"
        WHERE id=$result_id;
    SQL;

    $db->query($update_result);
}