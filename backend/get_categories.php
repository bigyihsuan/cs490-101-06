<?php
include(__DIR__ . "/../account.php");
global $db;

$html = "<label id=\"category\">Category<div><select name=\"category\">";
$html_end = "</select></div></label>";

$option = "<option value=\"%s\">%s</option>\n";

$query = "SELECT `category` FROM `CategoryTypes` ORDER BY `id`;";
($result = $db->query($query)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);

// error_log(print_r($rows, true));

foreach ($rows as $_ => $category) {
    $html .= sprintf($option, $category['category'], $category['category']);
}
$html .= $html_end;

// return questions ot caller
echo $html;