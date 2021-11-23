<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="student.css" rel="stylesheet">
    <title>CreateExam Page</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

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
    <header id="aa">
        <h1 style="text-align:center; color: #ebebeb;">Create Exam</h1>
    </header>

    <table>
        <tr>
            <td style="width:50%;background:#ededed;padding-left:10px;padding-right:10px;padding-top:35px;" valign="top">
                <div id="filters">
                    <script>
                        $('document').ready(function() {
                            $.post("../backend/get_filter.php", function(
                                data) {
                                $("#filters").empty();
                                $("#filters").append(data);
                                $("#filters").append(
                                    '<button id="filter_questions" onclick=filter()>Filter Questions</button>'
                                )
                            });
                        });
                    </script>
                </div>
                <script>
                    function filter() {
                        var difficulty = $(
                            'input[name="filter_difficulty"]:checked').val();
                        var category = $('input[name="filter_category"]:checked')
                            .val();
                        var constraint = $(
                            'input[name="filter_constraint"]:checked').val();

                        getQuestionBank("question_bank", true, difficulty, category,
                            constraint);
                    }
                </script>
                <div id="question_bank_div" style="width:100%;margin:0 auto;margin-top:30px;margin-bottom:50px;text-align:left;">
                    <script>
                        getQuestionBank("question_bank_div", true);
                    </script>
                </div>

            <td style="width:50%;padding-left:5%;padding-right:5%;padding-top:35px;background:#ededed;" valign="top">
                <p>Exam Questions</p>
                <form id="exam_questions_form" method="post">
                    <input type="submit"><br>
                    <input id="exam_title" type="text" placeholder="Exam Title">
                    <table id="exam_questions_table" align="center" border="1px" style="width: 600px; line-height: 40px;">
                        <thead>
                            <th>Question ID</th>
                            <th>Prompt</th>
                            <th>Difficulty</th>
                            <th>Category</th>
                            <th>Constraint</th>
                            <th>Max Score</th>
                            <th></th>
                        </thead>
                        <tbody id="exam_question_holder">

                        </tbody>
                    </table>
                </form>
                <script>
                    $("#exam_questions_form").on("submit", function(e) {
                        e.preventDefault();
                        var examTitle = $("#exam_title").val();
                        // console.log(examTitle);
                        var questions = $("#exam_question_holder")
                            .children()
                            .children()
                            .filter('[id$="_id"],[id$="_score"]')
                            .toArray()
                            .map(ele => ele.innerText !== '' ? ele
                                .innerText : $(ele).children(":first").val()
                            );
                        // console.log(questions);

                        var chunked = [...chunks(questions, 2)].map(tup =>
                            ({
                                [tup[0]]: tup[1],
                            }));
                        // console.log(chunked);

                        if (examTitle === "") {
                            alert("empty exam title");
                            return;
                        }

                        if (chunked.some(obj => obj.score === '')) {
                            alert("empty score, enter a score");
                            return;
                        }

                        $.post("/backend/create_exam.php", ({
                            exam_title: examTitle,
                            question_data: chunked
                        }));
                        $("#exam_question_holder").children().toArray()
                            .forEach(el => {
                                $(el).detach()
                            });
                        $("#exam_title").val('');
                        getQuestionBank("question_bank", true);
                    });
                </script>
            </td>
        </tr>
    </table>
    <script>
        function addToExam(id) {
            // console.log(id);
            var questionToAdd = $("#" + id).detach();
            // questionToAdd.children().map(function(index, element) {
            //     // console.log(index);
            //     // console.log(element);
            //     console.log(element.id + " " + element.innerHTML);
            // });

            questionToAdd.children('td[id$="_add_to_exam"]').css("display", "none");
            questionToAdd.children('td[id$="_remove_from_exam"]').css("display",
                "");
            questionToAdd.children('td[id$="_score"]').css("display", "");

            $("#exam_question_holder").append(questionToAdd);
            // console.log($("#" + id + "_add_to_exam"));
        }

        function removeFromExam(question_id) {
            console.log(question_id);
            $("#" + question_id).children('[id$="_add_to_exam"]').css("display",
                "");
            $("#" + question_id).children('[id$="_remove_from_exam"]').css(
                "display", "none");
            $("#" + question_id).children('[id$="_score"]').css("display", "none");

            $("#question_bank").append($("#" + question_id).detach());
        }
    </script>
</body>

</html>