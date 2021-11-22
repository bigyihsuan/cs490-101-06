<!DOCTYPE html>
<html>

<head>
    <link href="student.css" rel="stylesheet">
    <title>ReviewExam Page</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="./util.js"></script>
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
                <a href="ReviewExamList.php">Review Exam</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <h1 style="text-align:center; color: #ebebeb;">Review Student's Exam Grades for edit and comment</h1>

    <form id="exam_holder" method="post">
        <?php
        include(__DIR__ . "/../backend/get_exam_review.php");
        ?>
        <button type="submit">Save Review</button>
    </form>

    <script>
        $("#exam_holder").on("submit", function(e) {
            e.preventDefault();
            var elements = $("[id$='id'], [id*='score_'], textarea").toArray().map(
                ele => ele.innerText !== '' ? ele.innerText : $(ele).val());


            var ser_id = elements[0];
            elements = elements.slice(1);
            var chunked = [...chunks(elements, 3)].map(tup => ({
                result_id: tup[0],
                new_score: tup[1],
                comment: tup[2]
            }));

            var obj = {
                ser_id: ser_id,
                new_results: chunked
            };
            // console.log(obj);

            $.post("/backend/save_result.php", obj);

            window.location.replace("/webpages/ReviewExamList.html");
        });
    </script>

</body>

</html>