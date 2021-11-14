<?php

include("../account.php");
// include("../data_models.php");
global $db;

$query = "SELECT
`Question`.`id` AS id,
`Question`.`prompt` AS prompt,
`DifficultyTypes`.`id` AS difficulty_id,
`DifficultyTypes`.`difficulty` AS difficulty,
`CategoryTypes`.`id` AS category_id,
`CategoryTypes`.`category` AS category,
`ConsTypes`.`id` AS cons_id,
`ConsTypes`.`cons` AS cons
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

error_log($query . "\n");

($result = $db->query($query)) or die();
$html = <<<HTML
<table align="center" border="1px" style="width: 600px; line-height: 40px;">
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
foreach ($rows as $row) {
    $html .= <<<HTML
        <tr id="question_{$row['id']}">
            <td id="question_{$row['id']}_id">{$row['id']}</td>
            <td id="question_{$row['id']}_prompt">{$row['prompt']}</td>
            <td id="question_{$row['id']}_difficulty">{$row['difficulty']}</td>
            <td id="question_{$row['id']}_difficulty_id" style="display:none;">{$row['difficulty_id']}</td>
            <td id="question_{$row['id']}_category">{$row['category']}</td>
            <td id="question_{$row['id']}_category_id" style="display:none;">{$row['category_id']}</td>
            <td id="question_{$row['id']}_constraint">{$row['cons']}</td>
            <td id="question_{$row['id']}_constraint_id" style="display:none;">{$row['cons_id']}</td>
            <td id="question_{$row['id']}_add_to_exam">
                <button onclick=addToExam("question_{$row['id']}")>Add to Exam</button>
            </td>
        </tr>\n
        HTML;
}
$html .= "</table>";

echo $html;