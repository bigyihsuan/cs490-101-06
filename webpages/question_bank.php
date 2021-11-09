<?php

include("../account.php");
// include("../data_models.php");
global $db;

$query = "SELECT * FROM `Question`";

if ($_POST['category'] != "") {
    $category = $_POST['category'];
}
if ($_POST['difficulty'] != "") {
    $difficulty = $_POST['difficulty'];
}

if (isset($category) && isset($difficulty)) {
    $query .= " WHERE `category`=\"$category\" && `difficulty`=\"$difficulty\"";
} else if (isset($category)) {
    $query .= " WHERE `category`=\"$category\"";
} else if (isset($difficulty)) {
    $query .= " WHERE `difficulty`=\"$difficulty\"";
}

$query .= ";";

($result = $db->query($query)) or die();
$html = '
<table align="center" border="1px" style="width: 600px; line-height: 40px;">
    <tr>
        <th>Question ID</th>
        <th>Prompt</th>
        <th>Difficulty</th>
        <th>Category</th>
        <th></th>
    </tr>';
$rows = $result->fetch_all(MYSQLI_ASSOC);
foreach ($rows as $row) {
    $html .= "
        <tr>
            <td id=\"question_{$row['id']}_id\">{$row['id']}</td>
            <td id=\"question_{$row['id']}_prompt\">{$row['prompt']}</td>
            <td id=\"question_{$row['id']}_difficulty\">{$row['difficulty']}</td>
            <td id=\"question_{$row['id']}_category\">{$row['category']}</td>
            <td id=\"question_{$row['id']}_add_to_exam\"><button onclick=addToExam(\"question_{$row['id']}_id\")>Add to Exam</button></td>
        </tr>\n";
}

$html .= "</table>";
echo $html;