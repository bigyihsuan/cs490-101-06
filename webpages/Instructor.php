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
                <a href="Instructor.html">Home</a>
            </li>
            <li>
                <a href="AddQuestion.html">Add Questions</a>
            </li>
            <li>
                <a href="CreateExam.html">Create Exam</a>
            </li>
            <li>
                <a href="AutoGradeExam.html">AutoGrade Exam</a>
            </li>
            <li>
                <a href="ReviewExam.html">Review Exam</a>
            </li>
            <li>
                <a href="ReleaseGrade.html">Release Grade</a>
            </li>
            <li>
                <a class="active" href="login.html">Log Out</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <h1
        style="text-align:center; justify-content: center; line-height: 400px; color: #ebebeb;">
        <?php echo "Welcome {$_POST['username']}"; ?>
    </h1>
</body>

</html>