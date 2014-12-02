function clearQuestionPreviews() {
    $('.question, .answer').css('border', '1px solid black');
    $('.question').empty();

    $('#question_type_1 .answer').empty();
    $('#question_type_2 .answer').empty();
    $('#question_type_3 .answer').empty();

    $('#question_type_6 .answer').empty();
    $('#question_type_7 .answer').empty();
    $('#question_type_9 .answer').empty();

    $('.question_image img').removeAttr('src');
    $('.answer img').removeAttr('src');
}