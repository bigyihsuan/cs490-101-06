<?php
include("../util/functions.php");

session_start();

global $db;

$username = "";
$password = "";
if (isset($_POST['username'])) {
    $username = safe_post('username');
}
if (isset($_POST['password'])) {
    $password = safe_post('password');
    // TODO: hash passwords
    // hash("sha256", $password)
}

if ($username != "" && $password != "") {
    $_SESSION['is_logged'] = is_authenticated($username, $password);
    
    if ($_SESSION['is_logged']) {
        // get access level
        $num_users_query = "SELECT access FROM users WHERE name='$username'";
        ($users = $db->query($query)) or die($db->error);
        $row = $users->fetch_assoc();
        $access_level = $row['access'];

        if ($access_level == "ADMIN") {
            header("refresh:0; url=./admin.html");
        } else {
            header("refresh:0; url=./user.html");
        }
    } else {
        // return to login
        print "Incorrect username or password. Please try again.<br>";
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="webpages/front.css">
</head>

<body>
    <h2>hello CS 490!!!!!!</h2><br>
    <div class="Login">
        <form action="./backend/get_query.php" method="post">
            <label><b>User Name</b></label><br><br>
            <input type="text" name="username" id="user"><br><br><br>
            <label><b>Password</b></label><br><br>
            <input type="text" name="password" id="pass"><br><br><br>
            <button type="submit" id="submit">Submit</button>
        </form>
    </div>
</body>

</html>