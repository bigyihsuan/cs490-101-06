<!DOCTYPE html>
<html>

<head>
    <link href="student.css" rel="stylesheet">
    <title>Student Page</title>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="Student.php">Home</a>
            </li>
            <li>
                <a href="ListExam.html">List Exams</a>
            </li>
            <li>
                <a href="viewResults.php">Review Exam</a>
            </li>
            <li>
                <a class="active" href="../backend/logout.php">Log Out</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <h1
        style="text-align:center; justify-content: center; line-height: 400px; color: #ebebeb;">
        <?php session_start();
        echo "Welcome {$_SESSION['logged_user']}"; ?>
    </h1>
</body>

</html>