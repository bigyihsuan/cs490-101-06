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
    $query .= " WHERE `category`=$category && `difficulty`=$difficulty";
} else if (isset($category)) {
    $query .= " WHERE `category`=$category";
} else if (isset($difficulty)) {
    $query .= " WHERE `difficulty`=$difficulty";
}

$query .= ";";

($result = $db->query($query)) or die();
$html = '
<table align="center" border="1px" style="width: 600px; line-height: 40px;">
    <tr>
        <th>Prompt</th>
        <th>Difficulty</th>
        <th>Category</th>
    </tr>';
$rows = $result->fetch_all(MYSQLI_ASSOC);
foreach ($rows as $row) {
    $html .= "
        <tr>
            <td>{$row['prompt']}</td>
            <td>{$row['difficulty']}</td>
            <td>{$row['category']}</td>
        </tr>\n";
}

$html .= "</table>";
echo $html;