<?php
include("../account.php");
include("./data_models.php");
global $db;

$html = "<label id=\"cons\">Constraint<div><select name=\"constraint\">";
$html_end = "</select></div></label>";

$option = "<option value=\"%s\">%s</option>\n";

$query = "SELECT `cons` FROM `ConsTypes` ORDER BY `id`;";
($result = $db->query($query)) or die();
$rows = $result->fetch_all(MYSQLI_ASSOC);

// error_log(print_r($rows, true));

foreach ($rows as $_ => $cons) {
    $html .= sprintf($option, $cons['cons'], $cons['cons']);
}
$html .= $html_end;

// return questions ot caller
echo $html;