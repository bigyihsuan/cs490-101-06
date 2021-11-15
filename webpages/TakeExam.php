<!DOCTYPE html>
<html>

<head>
    <link href="student.css" rel="stylesheet">
    <title>Take Exam Page</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="util.js"></script>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="Student.html">Home</a>
            </li>
            <li>
                <a href="ListExam.html">List Exams</a>
            </li>
            <li>
                <a href="Review.html">Review Exam</a>
            </li>
            <li>
                <a class="active" href="/backend/logout.php">Log Out</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <h1
        style="text-align:left; justify-content: center; line-height: 100px; color: #ebebeb;">
        Exam Start Now!!!</h1>
    <form id="exam_holder">
        <?php
        include(__DIR__ . "/../backend/get_exam_form.php");
        ?>
        <button type="submit">Submit Exam</button>
    </form>
    <script>
    $("#exam_holder").on("submit", function(e) {
        e.preventDefault();
        var elements = $("[id$='id'], textarea").toArray().map(
            ele => ele.innerText !== '' ? ele.innerText :
            $(ele).val());
        // console.log(elements);

        var chunked = [...chunks(elements, 2)].map(tup => ({
            exam_question_id: tup[0],
            student_response: tup[1]
        }));

        var exam_id = $("#exam_id").val();

        // console.log(chunked);
        $.post("/backend/create_result.php", ({
            exam_id: exam_id,
            student_responses: chunked
        }));

        window.location.replace("/webpages/ListExam.html");
    });
    </script>
</body>

</html>