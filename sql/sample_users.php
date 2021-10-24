<?php
include "account.php";
include "backend/data_models.php";
global $db;

$users = [
    'alice' => ['apple' => User::STUDENT],
    'bob' => ['banana' => User::STUDENT],
    'charles' => ['cookie' => User::STUDENT],
    'daniel' => ['dessert' => User::STUDENT],
    'ena' => ['enter' => User::TEACHER],
];

$query = "INSERT INTO User (username, pass, access) VALUES ";

foreach ($users as $username => $value) {
    foreach ($value as $password => $access) {
        $hashed_password = password_hash($password . $username, null);
        $query .= "(\"$username\", \"$hashed_password\", \"$access\"),";
    }
}
$query = substr($query, 0, strlen($query) - 1) . ";";
echo "$query\n";

$query = "SELECT * FROM User";
$result = $db->query($query);
$rows = $result->fetch_all(MYSQLI_ASSOC);

foreach ($rows as $row) {
    echo "{$row['id']} {$row['username']} {$row['pass']} {$row['access']}\n";
}