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
        });
    });
}

function getDifficulties(id) {
    $('document').ready(function() {
        $.post("../backend/get_difficulties.php", function(data) {
            $('#' + id).append(data);
        });
    });
}

function getCategories(id) {
    $('document').ready(function() {
        $.post("../backend/get_categories.php", function(data) {
            $('#' + id).append(data);
        });
    });
}

function getConstraints(id) {
    $('document').ready(function() {
        $.post("../backend/get_constraints.php", function(data) {
            $('#' + id).append(data);
        });
    });
}

// https://stackoverflow.com/a/55435856/8143168
function* chunks(arr, n) {
    for (let i = 0; i < arr.length; i += n) {
        yield arr.slice(i, i + n);
    }
}