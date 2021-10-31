function getQuestionBank(id, category = "", difficulty = "") {
    values = {
        category: "",
        difficulty: ""
    };

    if (category !== "") {
        values.category = category;
    }
    if (difficulty !== "") {
        values.difficulty = difficulty;
    }

    $('document').ready(function() {
        $.post("./question_bank.php", values, function(data) {
            $('#' + id).append(data);
        });
    });
}