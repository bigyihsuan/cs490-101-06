function getQuestionBank(id, difficulty = "", category = "", constraint = "") {
    var values = {
        difficulty: "",
        category: "",
        constraint: ""
    };

    if (difficulty !== "") {
        values.difficulty = difficulty;
    }
    if (category !== "") {
        values.category = category;
    }
    if (constraint !== "") {
        values.constraint = constraint;
    }

    $('document').ready(function() {
        $.post("./question_bank.php", values, function(data) {
            $('#' + id).empty();
            $('#' + id).append(data);

            sorttable.makeSortable($("#question_bank")[0]);
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