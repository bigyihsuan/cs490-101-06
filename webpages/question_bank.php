<?php

include("../account.php");
// include("../data_models.php");
global $db;

$query = <<<SQL
SELECT
`Question`.`id` AS id,
`Question`.`prompt` AS prompt,
`DifficultyTypes`.`difficulty` AS difficulty,
`DifficultyTypes`.`id` AS difficulty_id,
`CategoryTypes`.`category` AS category,
`CategoryTypes`.`id` AS category_id,
`ConsTypes`.`cons` AS cons,
`ConsTypes`.`id` AS cons_id
FROM `Question`
JOIN `DifficultyTypes` ON `Question`.`difficulty`=`DifficultyTypes`.`id`
JOIN `CategoryTypes` ON `Question`.`category`=`CategoryTypes`.`id`
JOIN `ConsTypes` ON `Question`.`cons`=`ConsTypes`.`id`
SQL;

if ($_POST['category'] != "") {
    $category = $_POST['category'];
}
if ($_POST['difficulty'] != "") {
    $difficulty = $_POST['difficulty'];
}
if ($_POST['constraint'] != "") {
    $constraint = $_POST['constraint'];
}

$where_clause = array();
if (isset($category)) {
    error_log("category=$category");
    $where_clause[] = "`Question`.`category`=$category";
}
if (isset($difficulty)) {
    error_log("difficulty=$difficulty");
    $where_clause[] = "`Question`.`difficulty`=$difficulty";
}
if (isset($constraint)) {
    error_log("constraint=$constraint");
    $where_clause[] = "`Question`.`cons`=$constraint";
}

if (count($where_clause) > 0) {
    $query .= "\nWHERE";
    foreach ($where_clause as $condition) {
        $query .= "\n" . $condition . " && ";
    }
    $query = substr($query, 0, strlen($query) - 4);
}

$query .= "\nORDER BY `Question`.`id`;";

// error_log($query . "\n");

($result = $db->query($query)) or die();
$html = <<<HTML
<table id="question_bank" align="center" border="1px" style="width: 600px; line-height: 40px;">
    <tr>
        <th>Question ID</th>
        <th>Prompt</th>
        <th>Difficulty</th>
        <th>Category</th>
        <th>Constraint</th>
        <th></th>
    </tr>
HTML;
$rows = $result->fetch_all(MYSQLI_ASSOC);

$making_exam = isset($_POST['making_exam']) ? $_POST['making_exam'] : false;
$display_none = $making_exam ? "" : 'style="display:none;"';
foreach ($rows as $row) {
    $question_id = $row['id'];
    $html .= <<<HTML
        <tr id="question_{$question_id}" class="item">
            <td id="question_{$question_id}_id">{$question_id}</td>
            <td id="question_{$question_id}_prompt">{$row['prompt']}</td>
            <td id="question_{$question_id}_difficulty" sorttable_customkey="{$row['difficulty_id']}">{$row['difficulty']}</td>
            <td id="question_{$question_id}_category" sorttable_customkey="{$row['category_id']}">{$row['category']}</td>
            <td id="question_{$question_id}_constraint" sorttable_customkey="{$row['cons_id']}">{$row['cons']}</td>
            <td id="question_{$question_id}_max_score" style='display:none;'>
                <input type="number" placeholder="Question Score"/>
            </td>
            <td id="question_{$question_id}_add_to_exam" {$display_none}>
                <button type="button" onclick=addToExam('question_{$question_id}')>Add to Exam</button>
            </td>
            <td id="question_{$question_id}_remove_from_exam" style="display:none;">
                <button type="button" onclick=removeFromExam('question_{$question_id}')>Remove Question</button>
            </td>
        </tr>
        HTML;
    $get_test_cases_of_question = <<<SQL
        SELECT TestCase.`id` AS test_case_id, `input`, `output`
        FROM TestCase
        JOIN QuestionTestCase ON QuestionTestCase.test_case=TestCase.id
        JOIN Question ON QuestionTestCase.question=Question.id
        WHERE QuestionTestCase.question=$question_id;
    SQL;

    error_log($get_test_cases_of_question);

    ($result = $db->query($get_test_cases_of_question)) or die();
    $test_cases = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($test_cases as $test_case) {
        $input = $test_case['input'];
        $output = $test_case['output'];

        $html .= <<<HTML
        <tr>
            <td>$input</td>
            <td>=></td>
            <td>$output</td>
        </tr>
        HTML;
    }
}
$html .= '</table>';

echo $html;