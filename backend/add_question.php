<?php
// include("../account.php");
// global $db;

session_start();

echo "<p>Hello world!</p>";

foreach (array_keys($_POST) as $key) {
    print "<p>$key $_POST[$key]</p>";
}

header("status:303 href='backend/add_question.php'");