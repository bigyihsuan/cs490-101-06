<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>hello world</p>

    <form action="get_query.php" method="get">
        <input type="text" name="username" id="user"><br>
        <button type="submit">submit</button>
    </form>
</body>

</html>

<?php
include("../util/functions.php");
global $db;

$username = "";
if (isset($_GET['username'])) {
    $username = safe_get('username');
}

$query = "SELECT * FROM cs490_Users WHERE name='$username'";
// $query = "SELECT * FROM cs490_Users";
($users = $db->query($query)) or die($db->error);

while ($row = $users->fetch_assoc()) {
    printf("<p>id={$row['user_id']} name={$row['name']} pass={$row['pass']} access={$row['access']}</p>");
}
?>