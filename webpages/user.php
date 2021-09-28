<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php echo "<p>Greetings {$_SESSION['logged_user']}!</p>" ?>
    <p>You are a <strong>USER!</strong></p>
    <br>
    <a href="/backend/logout.hp">Logout</a>
</body>

</html>