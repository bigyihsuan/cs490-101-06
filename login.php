<?php
include("functions.php");

session_start();

global $db;

$username = "";
$password = "";
if (isset($_POST['username'])) {
    $username = safe_post('username');
}
if (isset($_POST['password'])) {
    $password = safe_post('password');
}

if ($username != "" && $password != "") {
    $_SESSION['is_logged'] = is_authenticated($username, $password);

    if ($_SESSION['is_logged']) {
        // get access level
        $access_level_query = "SELECT access FROM Users WHERE `id`='$username'";
        ($users = $db->query($access_level_query)) or die($db->error);
        $row = $users->fetch_assoc();
        $access_level = $row['access'];
        $_SESSION['logged_user'] = $username;

        if ($access_level == "ADMIN") {
            header("refresh:0; url=webpages/admin.php");
        } else {
            header("refresh:0; url=webpages/user.php");
        }
    } else {
        // return to login
        print "Incorrect username or password. Please try again.<br>";
    }
} ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Exam</title>
    <link rel="stylesheet" href="front.css">
</head>

<body>
    <h2>CS490: Design in Software Engineering</h2><br>
    <div class="Login">
        <form method="post" action="login.php">
            <label><b>Username</b></label><br><br>
            <input type="text" name="username" id="user"
                placeholder="Enter username"><br><br><br>
            <label><b>Password</b></label><br><br>
            <input type="password" name="password" id="pass"
                placeholder="Enter password"><br><br><br>
            <button type="submit" id="submit">Sign in</button>
        </form>
    </div>
</body>

</html>