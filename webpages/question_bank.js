function getQuestionBank(id) {
    $('document').ready(function() {
        $.post("./question_bank.php", function(data) {
            $('#' + id).append(data);
        });
    });
}