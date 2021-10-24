<?php

include("../account.php");
// include("../data_models.php");
global $db;

$query = "SELECT * FROM `Question`;";
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