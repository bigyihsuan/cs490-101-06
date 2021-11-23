<!DOCTYPE html>
<html>

<head>
    <link href="instructor.css" rel="stylesheet">
    <title>Instructor Page</title>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="Instructor.php">Home</a>
            </li>
            <li>
                <a href="AddQuestion.php">Add Questions</a>
            </li>
            <li>
                <a href="CreateExam.php">Create Exam</a>
            </li>
            <li>
                <a href="AutoGradeExam.php">AutoGrade Exam</a>
            </li>
            <li>
                <a href="ReviewExamList.html">Review Exam</a>
            </li>
            <li>
                <a class="active" href="/backend/logout.php">Log Out</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <h1 style="text-align:center; justify-content: center; line-height: 400px; color: #ebebeb;">
        <?php session_start();
        echo "Welcome {$_SESSION['logged_username']}"; ?>
    </h1>
</body>

</html>