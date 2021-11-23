<?php

include("../account.php");
// include("../data_models.php");
global $db;

$query = "SELECT
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
JOIN `ConsTypes` ON `Question`.`cons`=`ConsTypes`.`id`";

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
<table id="question_bank" class="sortable" align="center" border="1px" style="width: 600px; line-height: 40px;">
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

$makingExam = $_POST['making_exam'];
foreach ($rows as $row) {
    $html .= <<<HTML
        <tr id="question_{$row['id']}" class="item">
            <td id="question_{$row['id']}_id">{$row['id']}</td>
            <td id="question_{$row['id']}_prompt">{$row['prompt']}</td>
            <td id="question_{$row['id']}_difficulty" sorttable_customkey="{$row['difficulty_id']}">{$row['difficulty']}</td>
            <td id="question_{$row['id']}_category" sorttable_customkey="{$row['category_id']}">{$row['category']}</td>
            <td id="question_{$row['id']}_constraint" sorttable_customkey="{$row['cons_id']}">{$row['cons']}</td>
            <td id="question_{$row['id']}_max_score" style='display:none;'>
                <input type="number" placeholder="Question Score"/>
            </td>
            <td id="question_{$row['id']}_add_to_exam" {!$makingExam? "style="display:none;" : ""}>
                <button type="button" onclick=addToExam('question_{$row['id']}')>Add to Exam</button>
            </td>
            <td id="question_{$row['id']}_remove_from_exam" style="display:none;">
                <button type="button" onclick=removeFromExam('question_{$row['id']}')>Remove Question</button>
            </td>
        </tr>
        HTML;
}
$html .= '</table>';

echo $html;