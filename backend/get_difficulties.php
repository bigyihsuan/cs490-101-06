<?php
include("../account.php");
include("./data_models.php");
global $db;

$html = "<label id=\"difficulty\">Difficulty Level<div><select name=\"difficulty\">";
$html_end = "</select></div></label>";

$option = "<option value=\"%s\">%s</option>\n";

$query = "SELECT `difficulty` FROM `DifficultyTypes` ORDER BY `id`;";
($result = $db->query($query)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);

// error_log(print_r($rows, true));

foreach ($rows as $_ => $difficulty) {
    $html .= sprintf($option, $difficulty['difficulty'], $difficulty['difficulty']);
}
$html .= $html_end;

// return questions ot caller
echo $html;