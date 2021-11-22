<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="student.css" rel="stylesheet">
    <title>AddQuestions Page</title>

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
                <a href="ReviewExamList.php">Review Exam</a>
            </li>
        </ul>
        <div class="handle">
            Menu
        </div>
    </nav>
    <header id="aa">
        <h1 style="text-align:center; color: #ebebeb;">Add Questions</h1>
    </header>
    <table>
        <tr>
            <td style="width:30%;padding-left:10px;padding-right:10px;padding-top:35px;" valign="top">

                <form id="questionForm" method="post">
                    <div id="aa">
                        <label class="desc" for="question" id="question" style="text-align:center;">Question Box</label>
                        <div>
                            <textarea id="question" name="question" spellcheck="true" style="width:90%;height:100px;" tabindex="1"></textarea>
                        </div>
                    </div><br>
                    <!--
                    <div id="aa">
                        <label class="desc" for="function_name" id="function_name">Function Name</label>
                        <div><input class="field text fn" id="function_name" name="function_name" size="20" tabindex="2" type="text" value=""></div>
                    </div><br>
                    -->
                    <div id="questionCategory">
                        <script>
                            getCategories("questionCategory");
                        </script>
                    </div><br>

                    <div id="questionDifficulty">
                        <script>
                            getDifficulties("questionDifficulty");
                        </script>
                    </div><br>

                    <div id="questionConstraint">
                        <table>
                            <tr>
                                <td>
                                    <input type="checkbox" name="useConstraint" id="useConstraint">
                                    <label for="useConstraint">Use Constraint?</label>
                                </td>
                                <td>
                                    <script>
                                        getConstraints("questionConstraint");
                                    </script>
                                </td>
                            </tr>
                        </table>
                    </div><br>




                    <br />
                    <div>
                        <button type="button" class="btn btn-primary" onclick="addTag()">Add Test Case</button>
                        <button type="button" class="btn btn-primary" onclick="removeAllTags()">Remove All Test Cases</button>
                        <button id="saveForm" name="saveForm" type="submit" class="btn btn-primary">Submit Question</button>
                    </div>

                    <div id="testCases" class="container-fluid"></div>
                </form>



            </td>

            <td style="width:70%;padding-left:10px;padding-right:10px;padding-top:35px;" valign="top">
                <p style="color: #ebebeb;">Selected questions</p>
                <div id="question_bank" style="width:90%;margin:0 auto;margin-top:30px;margin-bottom:50px;text-align:left;">
                    <script>
                        getQuestionBank("question_bank");
                    </script>
                </div>
            </td>

        </tr>
    </table>
</body>

<script>
    function addTag(tag = '') {
        var div = document.createElement('div');
        var html = `
	<div class="row align-middle border" style="padding:0.3em">
		<div class="input-group">
			<input type="text" id="row${$('#testCases').children().length}Input" placeholder="Input" />
			<input type="text" id="row${$('#testCases').children().length}Output" placeholder="Result" />
			<button type="button" class="btn btn-secondary" title="Delete" onclick="removeTag(this)">&#10060;</button>
		</div>
	</div>`;
        // <!-- <input class="form-control" type="number" id="counter" min="0" value="0" /> -->

        div.id = "row" + $('#testCases').children().length;
        div.class = "container-fluid";
        div.innerHTML = html;
        $('#testCases').append(div);
        return $('#testCases').children().length;
    }

    function removeAllTags() {
        $('#testCases').empty();
    }

    function removeTag(ele) {
        $(ele).parents("[id^=row]").empty();
    }

    $("#questionForm").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        for (var i = 0; i < $("#testCases").children().length; i++) {
            var input = "row".concat(i, "Input");
            var output = "row".concat(i, "Output");
            data.push({
                "name": "test_cases_" + i,
                "value": JSON.stringify({
                    [$(`#${input}`).val()]: $(`#${output}`).val()
                })
            });
        }
        data.push(testCases);
        console.log(data);
        $.post("../backend/add_question.php", data);
        getQuestionBank("question_bank");
    });
</script>

</html>cript>
</body>

</html>