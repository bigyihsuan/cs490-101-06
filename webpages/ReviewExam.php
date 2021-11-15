<!DOCTYPE html>
<html>

<head>
    <link href="student.css" rel="stylesheet">
    <title>ReviewExam Page</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                <a class="active" href="/backend/logout.php">Log Out</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <h1 style="text-align:center; color: #ebebeb;">Review Student's Exam Grades
        for edit and comment</h1>

    <form id="exam_holder">
        <?php
        include(__DIR__ . "/../backend/get_exam_review.php");
        ?>
        <button type="submit">Save Review</button>
    </form>

</body>

</html>