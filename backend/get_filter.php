<?php
include(__DIR__ . "/../account.php");
global $db;

$difficulty_query = "SELECT * FROM `DifficultyTypes` ORDER BY `id`;";
($result = $db->query($difficulty_query)) or die();
$difficulty_types = $result->fetch_all(MYSQLI_ASSOC);

$category_query = "SELECT * FROM `CategoryTypes` ORDER BY `id`;";
($result = $db->query($category_query)) or die();
$category_types = $result->fetch_all(MYSQLI_ASSOC);

$constraint_query = "SELECT * FROM `ConsTypes` ORDER BY `id`;";
($result = $db->query($constraint_query)) or die();
$constraint_types = $result->fetch_all(MYSQLI_ASSOC);

$filter_div = <<<HTML
<table id="filter_question">
    %s
</table>
HTML;

$filter_row = <<<HTML
<tr>
    <td>%s</td>
    %s
</tr>
HTML;

$filter_data = <<<HTML
<td>%s</td>
HTML;

$filters = "";
$filters .= extract_type($difficulty_types, "difficulty", "id", "difficulty");
$filters .= extract_type($category_types, "category", "id", "category");
$filters .= extract_type($constraint_types, "constraint", "id", "cons");

echo sprintf($filter_div, $filters);

function extract_type($rows, string $type, string $id_key, string $value_key): string
{
    global $filter_data;
    global $filter_row;

    $row_data = "";
    $row_data .= sprintf($filter_data, filter_button($type, "", "All"));
    foreach ($rows as $row) {
        // echo print_r($row, true);
        $id = $row[$id_key];
        $value = $row[$value_key];
        $row_data .= sprintf($filter_data, filter_button($type, $id, $value));
    }
    return sprintf($filter_row, ucfirst($type) . ":", $row_data);
}

function filter_button(string $type, $id, string $text): string
{
    $filter_button = <<<HTML
<input type="radio" name="filter_%s" id="filter_%s_%s" value="%s" %s>%s</input>
HTML;
    return sprintf($filter_button, $type, $type, strtolower($text), $id, strcmp($text, "All") === 0 ? "checked" : "", $text);
}