<!DOCTYPE html>
<html>

<head>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
        crossorigin="anonymous">
    <link href="student.css" rel="stylesheet">
    <title>AutoGradeExam Page</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <script src="util.js"></script>
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
    <h1 style="text-align:center; color: #ebebeb;">Review Student's Exam Grades
        for edit and comment</h1>

    <div id="result_holder"></div>

    <script>
    $("document").ready(function() {
        // console.log("getting");
        $.post("../backend/get_exams_to_grade.php", function(data) {
            // console.log(data);
            $("#result_holder").empty();
            $("#result_holder").append(data);
        });
    })

    function autogradeExam(exam_id, student_id) {
        $.post("/backend/autograde_student_exam.php", ({
            exam_id: exam_id,
            student_id: student_id
        }));
        $("[id*='" + exam_id + "']").remove();
    }
    </script>

</body>

</html>