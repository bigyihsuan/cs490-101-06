<?php
session_start();
if (!isset($_SESSION['logged_user'])) {
    header("refresh:2; url=/login.html");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php echo "<p>Greetings {$_SESSION['logged_user']}!</p>" ?>
    <p>You are an <strong>ADMIN!</strong></p>
    <br>
    <a href="/backend/logout.php">Logout</a>
</body>

</html>