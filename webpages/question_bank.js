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
            $('#' + id).empty();
            $('#' + id).append(data);
        });
    });
}

function getDifficulties(id) {
    $('document').ready(function() {
        $.post("../backend/get_difficulties.php", values, function(data) {
            $('#' + id).append(data);
        });
    });
}

function getCategories(id) {
    $('document').ready(function() {
        $.post("../backend/get_categories.php", values, function(data) {
            $('#' + id).append(data);
        });
    });
}

function getConstraints(id) {
    $('document').ready(function() {
        $.post("../backend/get_constraints.php", values, function(data) {
            $('#' + id).append(data);
        });
    });
}